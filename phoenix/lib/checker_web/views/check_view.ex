defmodule CheckerWeb.CheckView do
  use CheckerWeb, :view

  def render("hello-world.json", _) do
    "Hello, world!"
  end

  def render("index.json", %{checks: checks}) do
    %{data: render_many(checks, __MODULE__, "page.json")}
  end

  def render("page.json", %{check: check}) do
    %{title: check.title}
  end

  def render("print.json", _) do
    %{status: :ok}
  end
end
