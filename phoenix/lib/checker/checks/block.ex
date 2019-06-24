defmodule Checker.Checks.Block do
  alias Checker.Tables.Plan.{Block, Key, SettingBlock}

  @checks ["size_from", "size_to"]

  def run(0, %Block{heading: "0"} = block, html) do
    content = find_opening_block_content(html)
    run_checks([], content, block, %{})
  end
  def run(index, %Block{} = block, html) do
    find_block(index - 1, block, html)
    |> do_run(block, html)
  end

  defp do_run(nil, _block, _html) do
    %{:error => :does_not_exist}
  end
  defp do_run(html_name, %Block{} = block, html) do
    content = find_content(html_name, block, html)
    run_checks(@checks, content, block, %{})
  end

  defp run_checks([check | tail], content, %Block{} = block, result) do
    result =
      case run_check(check, content, block) do
        {:error, error} -> Map.put_new(result, check, error)
        _ -> result
      end
    run_checks(tail, content, block, result)
  end
  defp run_checks([], content, %Block{} = block, result) do
    setting_blocks_checks = check_setting_blocks(SettingBlock.fetch(block), content, %{})
    key_checks = check_keys(Key.fetch(block), content, %{})
    result
    |> Map.put_new("settings", setting_blocks_checks)
    |> Map.put_new("keys", key_checks)
  end

  defp run_check("size_from", html_content, %Block{size_from: value}) do
    value = String.to_integer(value)
    length =
      html_content
      |> HtmlSanitizeEx.strip_tags
      |> String.trim
      |> String.length
    case length < value do
      true -> {:error, %{:excpected => value, :got => length}}
      _ -> {:ok}
    end
  end
  defp run_check("size_to", html_content, %Block{size_to: value}) do
    value = String.to_integer(value)
    length =
      html_content
      |> HtmlSanitizeEx.strip_tags
      |> String.trim
      |> String.length
    case length > value do
      true -> {:error, %{:excpected => value, :got => length}}
      _ -> {:ok}
    end
  end

  defp find_opening_block_content(html) do
    case Regex.run(~r/(.*)(?:<h\d+>|$)/Usu, html) do
      [_full, match] -> String.trim(match)
      _ -> ""
    end
  end

  defp find_content(html_name, %Block{heading: heading}, html) do
    prev_heading = String.to_integer(heading) - 1
    case Regex.run(~r/(<h#{heading}>#{html_name}<\/h#{heading}>.*)(?:<h(?:#{heading}|#{prev_heading})>|$)/Usu, html) do
      [_full, match] -> String.trim(match)
      _ -> ""
    end
  end

  defp find_block(index, %Block{name: name, heading: heading}, html) do
    name = String.downcase(name)
    block =
      Floki.find(html, "h2,h3,h4,h5,h6")
      |> Enum.with_index
      |> Enum.find(
           fn {{tag, _, [h]}, pos} ->
             pos == index && "h#{heading}" == tag && (
               h
               |> String.trim
               |> String.downcase) == name end
         )
    case block do
      {{_, _, [h]}, _} -> h
      _ -> nil
    end
  end

  defp check_keys([%Key{value: value} = key | tail], block_html, result) do
    result =
      case Checker.Checks.Key.run(key, block_html) do
        {:error, error} -> Map.put_new(result, value, error)
        _ -> result
      end
    check_keys(tail, block_html, result)
  end
  defp check_keys([], _, result) do
    result
  end

  defp check_setting_blocks([%SettingBlock{type: type} = setting_block | tail], block_html, result) do
    result =
      case Checker.Checks.SettingBlock.run(setting_block, block_html) do
        {:error, error} -> Map.put_new(result, type, error)
        _ -> result
      end
    check_setting_blocks(tail, block_html, result)
  end
  defp check_setting_blocks([], _, result) do
    result
  end
end
