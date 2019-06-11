defmodule Checker.Converter do
  alias Checker.Tables.{Check, Setting}
  alias Checker.Tables.Plan.{Plan, Block, Key, SettingBlock}

  def convert(request) do
    Memento.transaction fn ->
      check = save_check(request)
      with %{"settings" => settings} <- request do
        save_settings(check, settings)
      end
      with %{"plan" => plan} <- request do
        save_plan(check, plan)
      end
    end
  end

  defp save_check(%{"html" => html}) do
    %Check{html: html}
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
           },
           "blocks" => blocks,
           "opening_block" => opening_block,
           "closing_block" => closing_block
         }
       ) do
    plan =
      %Plan{size_from: size_from, size_to: size_to, check_id: check_id}
      |> Memento.Query.write
    save_blocks(plan, blocks)
    if is_map(opening_block) do
      save_block(plan, opening_block)
    end
    if is_map(closing_block) do
      save_block(plan, closing_block)
    end
  end

  defp save_blocks(%Plan{} = plan, [head | tail]) do
    save_block(plan, head)
    save_blocks(plan, tail)
  end
  defp save_blocks(_, []) do
  end

  defp save_block(
         %Plan{id: plan_id},
         %{
           "heading" => heading,
           "description" => description,
           "sizes" => %{
             "from" => size_from,
             "to" => size_to
           },
           "keys" => keys,
           "setting_blocks" => setting_blocks
         }
       ) do
    block =
      %Block{heading: heading, description: description, size_from: size_from, size_to: size_to, plan_id: plan_id}
      |> Memento.Query.write
    save_keys(block, keys)
    save_setting_blocks(block, setting_blocks)
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
