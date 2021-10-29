FROM php:alpine

RUN apk update 
RUN apk upgrade 
RUN apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/v3.7/main/ nodejs=14.18.1-r0 
RUN apk add --no-cache bash lcms2-dev g++ make git pkgconfig autoconf automake libtool nasm build-base zlib-dev libpng libpng-dev jpeg-dev libc6-compat
RUN apk add --no-cache --update-cache --repository http://dl-cdn.alpinelinux.org/alpine/v3.12/community yarn=1.22.4-r0
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY --chown=www-data:www-data . /var/www/build

RUN composer clearcache

RUN cd /var/www/build \
    && composer install --no-dev \
    && composer dump -o \
    && yarn \
    && yarn build:production \
    && rm -rf node_modules composer* *.json README* *.rb assets/scss *.lock *.mix.*\
