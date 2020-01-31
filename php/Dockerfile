FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /srv/parser

CMD ["php-fpm"]
