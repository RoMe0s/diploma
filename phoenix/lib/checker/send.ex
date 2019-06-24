defmodule Checker.Send do
  alias Checker.Tables.Check

  def send(%{} = check_result, %Check{callback_url: callback_url}) do
    {:ok, body} = Jason.encode(check_result)
    HTTPoison.post(callback_url, body, [{"Content-type", "application/json"}])
    |> do_send
  end

  defp do_send({:ok, %{status_code: 200}}) do
    Checker.Queue.finished
  end
  defp do_send(response) do
    Checker.Queue.restart
  end
end
