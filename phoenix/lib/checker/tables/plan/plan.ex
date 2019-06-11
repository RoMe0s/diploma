defmodule Checker.Tables.Plan.Plan do
  @enforce_keys [:check_id, :size_from, :size_to]
  use Memento.Table,
    attributes: [:id, :check_id, :size_from, :size_to],
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
