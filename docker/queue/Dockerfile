FROM php:7.3-cli

#Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    supervisor \
    libzip-dev \
    unzip \
    zip

#Install extensions
RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install pdo_mysql zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
