FROM phpdockerio/php73-cli:latest

RUN apt-get update && apt-get install -y --no-install-recommends \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /application

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]