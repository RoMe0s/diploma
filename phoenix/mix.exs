defmodule Checker.MixProject do
  use Mix.Project

  def project do
    [
      app: :checker,
      version: "0.1.0",
      elixir: "~> 1.5",
      elixirc_paths: elixirc_paths(Mix.env()),
      compilers: [:phoenix] ++ Mix.compilers(),
      start_permanent: Mix.env() == :prod,
      deps: deps()
    ]
  end

  # Configuration for the OTP application.
  #
  # Type `mix help compile.app` for more information.
  def application do
    [
      mod: {Checker.Application, []},
      extra_applications: [:logger, :runtime_tools]
    ]
  end

  # Specifies which paths to compile per environment.
  defp elixirc_paths(:test), do: ["lib", "test/support"]
  defp elixirc_paths(_), do: ["lib"]

  # Specifies your project dependencies.
  #
  # Type `mix help deps` for examples and options.
  defp deps do
    [
      {:phoenix, "~> 1.4.3"},
      {:jason, "~> 1.0"},
      {:plug_cowboy, "~> 2.0"},
      {:memento, "~> 0.3.1"},
      {:html_sanitize_ex, "~> 1.3.0-rc3"},
      {:floki, "~> 0.21.0"},
      {:stemmer, "~> 1.0"},
      {:httpoison, "~> 1.4"}
    ]
  end
end
