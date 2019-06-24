defmodule Checker.Store do
  alias Checker.Tables.{Check, Setting}
  alias Checker.Tables.Plan.{Plan, Block, Key, SettingBlock}

  def store(request) do
    Memento.transaction fn ->
      check = save_check(request)
      with %{"settings" => settings} <- request do
        save_settings(check, Map.values(settings))
      end
      with %{"plan" => plan} <- request do
        save_plan(check, plan)
      end
    end
  end

  defp save_check(%{"html" => html, "callback_url" => callback_url}) do
    %Check{html: html, callback_url: callback_url}
    |> Memento.Query.write
  end

  defp save_settings(%Check{} = check, [head | tail]) do
    save_setting(check, head)
    save_settings(check, tail)
  end
  defp save_settings(_, []) do
  end

  defp save_setting(%Check{id: check_id}, %{"key" => key, "value" => value}) do
    %Setting{key: key, value: value, check_id: check_id}
    |> Memento.Query.write
  end

  defp save_plan(
         %Check{id: check_id},
         %{
           "sizes" => %{
             "from" => size_from,
             "to" => size_to
           }
         } = plan_data
       ) do
    plan =
      %Plan{size_from: size_from, size_to: size_to, check_id: check_id}
      |> Memento.Query.write
    save_opening_block(plan, plan_data)
    save_blocks(plan, plan_data)
  end

  defp save_blocks(%Plan{} = plan, %{"blocks" => blocks}) do
    do_save_blocks(plan, Map.values(blocks))
  end
  defp save_blocks(_, _) do
  end

  defp save_opening_block(%Plan{} = plan, %{"opening_block" => opening_block}) do
    if is_map(opening_block) do
      save_block(plan, opening_block)
    end
  end
  defp save_opening_block(_, _) do
  end

  defp do_save_blocks(%Plan{} = plan, [head | tail]) do
    save_block(plan, head)
    save_blocks(plan, tail)
  end
  defp do_save_blocks(_, []) do
  end

  defp save_block(
         %Plan{id: plan_id},
         %{
           "heading" => heading,
           "sizes" => %{
             "from" => size_from,
             "to" => size_to
           }
         } = block_data
       ) do
    block =
      %Block{heading: heading, size_from: size_from, size_to: size_to, plan_id: plan_id}
      |> do_save_block(block_data)
    with %{"keys" => keys} <- block_data do
      save_keys(block, Map.values(keys))
    end
    with %{"settings" => setting_blocks} <- block_data do
      save_setting_blocks(block, Map.values(setting_blocks))
    end
  end

  defp do_save_block(%Block{} = block, %{"name" => name}) do
    %{block | name: name}
    |> Memento.Query.write
  end
  defp do_save_block(%Block{} = block, _) do
    Memento.Query.write(block)
  end

  defp save_keys(%Block{} = block, [head | tail]) do
    save_key(block, head)
    save_keys(block, tail)
  end
  defp save_keys(_, []) do
  end

  defp save_key(%Block{id: block_id}, %{"value" => value, "type" => type, "count" => count}) do
    %Key{value: value, type: type, count: count, block_id: block_id}
    |> Memento.Query.write
  end

  defp save_setting_blocks(%Block{} = block, [head | tail]) do
    save_setting_block(block, head)
    save_setting_blocks(block, tail)
  end
  defp save_setting_blocks(_, []) do
  end

  defp save_setting_block(%Block{id: block_id}, %{"min" => min, "max" => max, "type" => type}) do
    %SettingBlock{min: min, max: max, type: type, block_id: block_id}
    |> Memento.Query.write
  end
end
