defmodule Checker.Tables.Check do
  @enforce_keys [:html]
  use Memento.Table,
    attributes: [:id, :html],
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

  def store(%__MODULE__{} = record) do
    Memento.transaction fn ->
      Memento.Query.write(record)
    end
  end

  def delete(%__MODULE__{} = record) do
    Memento.transaction fn ->
      Memento.Query.delete_record(record)
    end
  end
end
