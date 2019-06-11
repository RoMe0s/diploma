defmodule Checker.Tables.Plan.Block do
  @enforce_keys [:plan_id, :heading, :description, :size_from, :size_to]
  use Memento.Table,
    attributes: [:id, :plan_id, :heading, :description, :size_from, :size_to],
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
