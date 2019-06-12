FROM elixir:1.8.2

WORKDIR /application

RUN mix local.hex --force && \
    mix local.rebar --force && \
    mix hex.info

EXPOSE 4000

RUN mix archive.install --force hex phx_new 1.4.8