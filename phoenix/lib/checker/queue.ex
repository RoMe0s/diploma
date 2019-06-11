# 1) Беремо перших @limit записів та доповнюємо в do_next
defmodule Checker.Queue do
  alias Checker.Tables.Check
  use Agent

  def start_link(_) do
    records = Check.all()
    Agent.start_link(fn -> records end, name: __MODULE__)
  end

  def push(%Check{} = record) do
    {:ok, record} = Check.store(record)
    Agent.cast(__MODULE__, fn state -> state ++ [record] end)
  end

  def current do
    Agent.get(__MODULE__, fn
      [current | _] -> current
      [] -> nil
    end)
  end

  def next do
    Agent.get(__MODULE__, &do_next/1)
  end

  defp do_next([current | [next | all]]) do
    Check.delete(current)
    Agent.cast(__MODULE__, fn _ -> [next | all] end)
    next
  end

  defp do_next([current]) do
    Check.delete(current)
    Agent.cast(__MODULE__, fn _ -> [] end)
    nil
  end

  defp do_next([]) do
    nil
  end
end
