defmodule Checker.Tables.Plan.Block do
  @enforce_keys [:plan_id, :heading, :size_from, :size_to]
  use Memento.Table,
      attributes: [:id, :plan_id, :heading, :name, :size_from, :size_to],
      type: :ordered_set,
      autoincrement: true

  def fetch(%Checker.Tables.Plan.Plan{id: plan_id}) do
    records =
      Memento.transaction fn ->
        Memento.Query.select(__MODULE__, [{:==, :plan_id, plan_id}, {:>, :heading, "1"}])
      end
    case records do
      {:ok, records} -> records
      _ -> nil
    end
  end

  def fetch_opening(%Checker.Tables.Plan.Plan{id: plan_id}) do
    records =
      Memento.transaction fn ->
        Memento.Query.select(__MODULE__, [{:==, :plan_id, plan_id}, {:==, :heading, "0"}])
      end
    case records do
      {:ok, records} -> records
      _ -> nil
    end
  end
end
