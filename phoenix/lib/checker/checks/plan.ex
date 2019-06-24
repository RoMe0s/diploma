defmodule Checker.Checks.Plan do
  alias Checker.Tables.Plan.Plan

  @checks ["size_from", "size_to"]

  def run(%Plan{} = plan, html) do
    run_checks(@checks, plan, html, %{})
  end

  defp run_checks([check | tail], %Plan{} = plan, html, result) do
    result =
      case run_check(check, plan, html) do
        {:error, error} -> Map.put_new(result, check, error)
        _ -> result
      end
    run_checks(tail, plan, html, result)
  end
  defp run_checks([], _, _, result) do
    result
  end

  defp run_check("size_from", %Plan{size_from: size_from}, html) do
    size_from = String.to_integer(size_from)
    length =
      html
      |> HtmlSanitizeEx.strip_tags
      |> String.trim
      |> String.length
    case length < size_from do
      true -> {:error, %{:excpected => size_from, :got => length}}
      _ -> :ok
    end
  end

  defp run_check("size_to", %Plan{size_to: size_to}, html) do
    size_to = String.to_integer(size_to)
    length =
      html
      |> HtmlSanitizeEx.strip_tags
      |> String.trim
      |> String.length
    case length > size_to do
      true -> {:error, %{:excpected => size_to, :got => length}}
      _ -> :ok
    end
  end
end
