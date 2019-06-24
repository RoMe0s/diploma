defmodule Checker.Tables.Setting do
  @enforce_keys [:check_id, :key, :value]
  use Memento.Table,
      attributes: [:id, :check_id, :key, :value],
      type: :ordered_set,
      autoincrement: true

  def fetch(%Checker.Tables.Check{id: check_id}) do
    records =
      Memento.transaction fn ->
        Memento.Query.select(__MODULE__, {:==, :check_id, check_id})
      end
    case records do
      {:ok, records} -> records
      _ -> nil
    end
  end
end
