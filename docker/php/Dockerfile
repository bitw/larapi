FROM php:8.3-fpm as production

ARG UID=1000
ARG GID=1000

RUN groupadd -g $GID -o -f app && useradd --no-create-home -u $UID -g $GID -o app

RUN apt-get update \
    && apt-get install -y  \
    libpq-dev \
    zip \
    unzip \
    libzip-dev \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && pecl install -f redis \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pgsql pdo_pgsql zip gd \
    && docker-php-ext-enable redis \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /usr/share/doc/* /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /app

COPY php.ini /usr/local/etc/php/conf.d/php.ini

FROM production as dev

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN pecl install -f xdebug-3.3.1 \
    && docker-php-ext-enable xdebug \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /usr/share/doc/* /var/lib/apt/lists/* /tmp/* /var/tmp/*
