defmodule Checker.Tables.Setting do
  @enforce_keys [:check_id, :key, :value]
  use Memento.Table,
    attributes: [:id, :check_id, :key, :value],
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
