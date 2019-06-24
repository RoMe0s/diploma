defmodule Checker.Tables.Plan.Key do
  @enforce_keys [:block_id, :value, :count, :type]
  use Memento.Table,
      attributes: [:id, :block_id, :value, :count, :type],
      type: :ordered_set,
      autoincrement: true

  def fetch(%Checker.Tables.Plan.Block{id: block_id}) do
    records =
      Memento.transaction fn ->
        Memento.Query.select(__MODULE__, {:==, :block_id, block_id})
      end
    case records do
      {:ok, records} -> records
      _ -> nil
    end
  end
end
