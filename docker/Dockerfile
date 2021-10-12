FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
        git \
        wget \
        unzip \
        libaio1 \
        libpq-dev \
        libssh-dev \
        libonig-dev \
        libbz2-dev \
    && docker-php-ext-install \
        pcntl \
        mbstring \
        bcmath \
        mysqli \
        pdo \
        pdo_mysql \
        bz2 \
    && docker-php-ext-enable opcache

COPY php/php.ini /usr/local/etc/php/php.ini

# Install OPcache
COPY php/conf.d/opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

# Install APCu
RUN pecl install apcu \
    && docker-php-ext-enable apcu
COPY php/conf.d/apcu.ini /usr/local/etc/php/conf.d/docker-php-ext-apcu.ini

RUN apt-get install -y zlib1g-dev libicu-dev g++ \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN wget https://get.symfony.com/cli/installer -O - | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN usermod -u 1000 www-data
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/

EXPOSE 8080

RUN ls -lisa /var/www
