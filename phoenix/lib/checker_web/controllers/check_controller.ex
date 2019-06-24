defmodule CheckerWeb.CheckController do
  use CheckerWeb, :controller

  def store(conn, params) do
    Checker.Store.store(params)

    render(conn, "print.json", [])
  end
end
