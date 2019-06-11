defmodule Checker.Tables.Plan.SettingBlock do
  @enforce_keys [:block_id, :min, :max, :type]
  use Memento.Table,
    attributes: [:id, :block_id, :min, :max, :type],
    type: :ordered_set,
    autoincrement: true

  def all do
    records =
      Memento.transaction fn ->
      Memento.Query.all(__MODULE__)
    end
    case records do
      {:ok, records} -> records
      _ -> []
    end
  end
end
