defmodule Checker.Check do
  alias Checker.Tables.{Check, Setting}
  alias Checker.Tables.Plan.{Plan, Block}

  def check(%Check{} = check) do
    html = HtmlSanitizeEx.basic_html(check.html)
    settings = check_settings(Setting.fetch(check), html, %{})
    plan = check_plan(Plan.fetch(check), html)
    %{:settings => settings, :plan => plan}
    |> Checker.Send.send(check)
  end

  defp check_settings([%Setting{} = setting | tail], html, result) do
    result =
      case Checker.Checks.Setting.run(setting.key, setting.value, html) do
        {:error, error} -> Map.put_new(result, setting.key, error)
        _ -> result
      end
    check_settings(tail, html, result)
  end
  defp check_settings(_, _, result) do
    result
  end

  defp check_plan(%Plan{} = plan, html) do
    result = Checker.Checks.Plan.run(plan, html)
    blocks =
      plan
      |> Block.fetch
      |> Enum.with_index(1)
    opening_block =
      plan
      |> Block.fetch_opening
      |> Enum.with_index
    opening_block ++ blocks
    |> check_blocks(html, %{})
    |> (&(Map.put_new(result, "blocks", &1))).()
  end

  defp check_blocks([{%Block{} = block, index} | tail], html, result) do
    check_result = Checker.Checks.Block.run(index, block, html)
    check_blocks(tail, html, Map.put_new(result, index, check_result))
  end
  defp check_blocks([], _, result) do
    result
  end
end
