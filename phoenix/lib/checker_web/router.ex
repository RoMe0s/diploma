defmodule CheckerWeb.Router do
  use CheckerWeb, :router

  pipeline :api do
    plug :accepts, ["json"]
  end

  scope "/api", CheckerWeb do
    pipe_through :api
  end
end
