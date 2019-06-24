defmodule Checker.Checks.SettingBlock do
  alias Checker.Tables.Plan.SettingBlock

  def run(%SettingBlock{min: min, max: max, type: "video"}, block_html) do
    count =
      Floki.find(block_html, "iframe")
      |> Enum.count
    prepare_result(min, max, count)
  end

  def run(%SettingBlock{min: min, max: max, type: type}, block_html) do
    count =
      Floki.find(block_html, type)
      |> Enum.count
    prepare_result(min, max, count)
  end

  defp prepare_result(min, max, count) do
    cond do
      count < min -> {:error, %{:excpected => min, :got => count}}
      count > max -> {:error, %{:excpected => max, :got => count}}
      true -> {:ok}
    end
  end
end
