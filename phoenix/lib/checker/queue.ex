defmodule Checker.Queue do
  alias Checker.Tables.Check
  use GenServer

  @timeout 5_000

  def start_link(_) do
    GenServer.start_link(__MODULE__, Check.fetch, name: __MODULE__)
  end

  def init(state) do
    Process.send_after(self(), :tick, @timeout)
    {:ok, state}
  end

  def handle_info(:tick, %Check{} = check) do
    do_tick(check)
  end
  def handle_info(:tick, _) do
    do_tick()
  end

  def handle_cast(:tick, %Check{} = check) do
    do_tick(check)
  end
  def handle_cast(:tick, _) do
    do_tick()
  end

  def handle_cast(:finished, %Check{} = check) do
    Checker.Delete.delete(check)
    Process.send_after(self(), :tick, @timeout)
    {:noreply, Check.fetch}
  end

  def restart do
    GenServer.cast(__MODULE__, :tick)
  end

  def finished() do
    GenServer.cast(__MODULE__, :finished)
  end

  defp do_tick(%Check{} = check) do
    spawn_link(Checker.Check, :check, [check])
    {:noreply, check}
  end
  defp do_tick() do
    Process.send_after(self(), :tick, @timeout)
    {:noreply, Check.fetch}
  end
end
