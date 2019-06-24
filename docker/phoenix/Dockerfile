FROM elixir:1.8.2

WORKDIR /application

COPY docker-entrypoint.sh /usr/local/bin/

RUN mix local.hex --force && \
    mix local.rebar --force && \
    mix hex.info

EXPOSE 4000

RUN mix archive.install --force hex phx_new 1.4.8

RUN ["chmod", "+x", "/usr/local/bin/docker-entrypoint.sh"]

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]