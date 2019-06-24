defmodule Checker.Tables.Check do
  @enforce_keys [:html, :callback_url]
  use Memento.Table,
      attributes: [:id, :html, :callback_url],
      type: :ordered_set,
      autoincrement: true

  def fetch do
    records =
      Memento.transaction fn ->
        Memento.Query.all(__MODULE__)
      end
    case records do
      {:ok, [head | _]} -> head
      _ -> nil
    end
  end
end
