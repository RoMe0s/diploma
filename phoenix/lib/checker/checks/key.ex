defmodule Checker.Checks.Key do
  alias Checker.Tables.Plan.Key

  def run(%Key{value: value, count: count, type: "not strict"}, block_html) do
    count = String.to_integer(count)
    key =
      Stemmer.stem(value)
      |> Enum.join("\\s")
      |> prepare_value
    matches =
      Regex.scan(~r/#{key}/ui, block_html)
      |> Enum.count
    case count == matches do
      false -> {:error, %{:excpected => count, :got => matches}}
      _ -> {:ok}
    end
  end

  def run(%Key{value: value, count: count, type: _}, block_html) do
    count = String.to_integer(count)
    matches =
      Regex.scan(~r/#{prepare_value(value)}/ui, block_html)
      |> Enum.count
    case count == matches do
      false -> {:error, %{:excpected => count, :got => matches}}
      _ -> {:ok}
    end
  end

  defp prepare_value(value) do
    Regex.escape(value)
  end
end
