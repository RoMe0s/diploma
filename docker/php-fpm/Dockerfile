FROM php:7.3-fpm

#Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    zip \
    git

#Install extensions
RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install pdo_mysql zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install npm
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash
RUN apt-get install --yes nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN useradd -ms /bin/bash newuser
USER newuser

EXPOSE 9000
CMD ["php-fpm"]
