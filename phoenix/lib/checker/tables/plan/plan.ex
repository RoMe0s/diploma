defmodule Checker.Tables.Plan.Plan do
  @enforce_keys [:check_id, :size_from, :size_to]
  use Memento.Table,
      attributes: [:id, :check_id, :size_from, :size_to],
      type: :ordered_set,
      autoincrement: true

  def fetch(%Checker.Tables.Check{id: check_id}) do
    records =
      Memento.transaction fn ->
        Memento.Query.select(__MODULE__, {:==, :check_id, check_id})
      end
    case records do
      {:ok, [head | _]} -> head
      _ -> nil
    end
  end
end
