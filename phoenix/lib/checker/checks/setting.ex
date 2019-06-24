defmodule Checker.Checks.Setting do

  def run("DisallowTitle3NextToTitle2", "1", html) do
    Floki.find(html, "*")
    |> disallow_title_3_next_to_title_2(nil)
  end

  def run("MinimumNumberOfLettersInTheTitle", value, html) do
    value = String.to_integer(value)
    h =
      Floki.find(html, "h2,h3,h4,h5,h6")
      |> Enum.find(fn {_, _, [h]} -> String.length(h) < value end)
    case h do
      {_, _, [h]} -> {
                       :error,
                       %{
                         :part => h,
                         :excpected => value,
                         :got => String.length(h)
                       }
                     }
      _ -> {:ok}
    end
  end

  def run("MaximumNumberOfLettersInTheTitle", value, html) do
    value = String.to_integer(value)
    h =
      Floki.find(html, "h2,h3,h4,h5,h6")
      |> Enum.find(fn {_, _, [h]} -> String.length(h) > value end)
    case h do
      {_, _, [h]} -> {
                       :error,
                       %{
                         :part => h,
                         :excpected => value,
                         :got => String.length(h)
                       }
                     }
      _ -> {:ok}
    end
  end

  def run("MinimumNumberOfLettersInTheParagraph", value, html) do
    value = String.to_integer(value)
    p =
      Floki.find(html, "p")
      |> Enum.find(fn {_, _, [p]} -> String.length(p) < value end)
    case p do
      {_, _, [p]} -> {
                       :error,
                       %{
                         :part => p,
                         :excpected => value,
                         :got => String.length(p)
                       }
                     }
      _ -> {:ok}
    end
  end

  def run("MaximumNumberOfLettersInTheParagraph", value, html) do
    value = String.to_integer(value)
    p =
      Floki.find(html, "p")
      |> Enum.find(fn {_, _, [p]} -> String.length(p) > value end)
    case p do
      {_, _, [p]} -> {
                       :error,
                       %{
                         :part => p,
                         :excpected => value,
                         :got => String.length(p)
                       }
                     }
      _ -> {:ok}
    end
  end

  def run(_, _, _) do
    {:ok}
  end

  defp disallow_title_3_next_to_title_2([head | tail], nil) do
    disallow_title_3_next_to_title_2(tail, head)
  end
  defp disallow_title_3_next_to_title_2([{"h3", _, h} | _tail], {"h2", _, _}) do
    {:error, %{:part => h}}
  end
  defp disallow_title_3_next_to_title_2([head | tail], _prev) do
    disallow_title_3_next_to_title_2(tail, head)
  end
  defp disallow_title_3_next_to_title_2([], _) do
    {:ok}
  end
end
