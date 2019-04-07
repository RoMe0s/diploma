FROM elixir:1.8.1

RUN mix local.hex --force

RUN mix archive.install --force hex phx_new 1.4.3

WORKDIR /application

CMD ["mix", "phx.server"]