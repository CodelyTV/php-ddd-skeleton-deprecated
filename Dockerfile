FROM php:7.3.6-fpm-alpine
WORKDIR /app

RUN apk --update upgrade

RUN apk add --no-cache autoconf automake make gcc g++ icu-dev rabbitmq-c rabbitmq-c-dev

RUN pecl install amqp-1.9.4 \
    && pecl install apcu-5.1.17 \
    && pecl install xdebug-2.7.0RC2 \
    && docker-php-ext-install -j$(nproc) bcmath opcache intl pdo_mysql \
    && docker-php-ext-enable amqp apcu opcache xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
