defmodule Checker.Delete do
  alias Checker.Tables.{Check, Setting}
  alias Checker.Tables.Plan.{Plan, Block, Key, SettingBlock}

  def delete(%Check{} = check) do
    Memento.transaction fn ->
      delete_settings(Setting.fetch(check))
      delete_plan(Plan.fetch(check))
      Memento.Query.delete_record(check)
    end
  end

  defp delete_settings([%Setting{} = setting | tail]) do
    Memento.Query.delete_record(setting)
    delete_settings(tail)
  end
  defp delete_settings(_) do
  end

  defp delete_plan(%Plan{} = plan) do
    delete_blocks(Block.fetch(plan))
    delete_blocks(Block.fetch_opening(plan))
    Memento.Query.delete_record(plan)
  end
  defp delete_plan(_) do
  end

  defp delete_blocks([%Block{} = block | tail]) do
    delete_setting_blocks(SettingBlock.fetch(block))
    delete_keys(Key.fetch(block))
    Memento.Query.delete_record(block)
    delete_blocks(tail)
  end
  defp delete_blocks(_) do
  end

  defp delete_setting_blocks([%SettingBlock{} = setting_block | tail]) do
    Memento.Query.delete_record(setting_block)
    delete_setting_blocks(tail)
  end
  defp delete_setting_blocks(_) do
  end

  defp delete_keys([%Key{} = key | tail]) do
    Memento.Query.delete_record(key)
    delete_keys(tail)
  end
  defp delete_keys(_) do
  end
end
