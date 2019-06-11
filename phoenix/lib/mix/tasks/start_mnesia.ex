defmodule Mix.Tasks.StartMnesia do
  alias Checker.Tables.{Check, Setting, Plan}
  use Mix.Task

  def run(_) do
    nodes = [node()]
    Memento.stop
    Memento.Schema.create(nodes)
    Memento.start

    Memento.Table.create!(Check, disc_copies: nodes)
    Memento.Table.create!(Setting, disc_copies: nodes)
    Memento.Table.create!(Plan.Plan, disc_copies: nodes)
    Memento.Table.create!(Plan.Block, disc_copies: nodes)
    Memento.Table.create!(Plan.Key, disc_copies: nodes)
    Memento.Table.create!(Plan.SettingBlock, disc_copies: nodes)
  end
end
