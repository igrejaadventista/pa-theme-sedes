FROM php:alpine

RUN apk update 
RUN apk upgrade 
RUN apk add --no-cache bash lcms2-dev g++ make git pkgconfig autoconf automake libtool nasm build-base zlib-dev libpng libpng-dev jpeg-dev libc6-compat nodejs npm zip
RUN apk add --no-cache --update-cache --repository http://dl-cdn.alpinelinux.org/alpine/v3.12/community yarn=1.22.4-r0
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY --chown=www-data:www-data . /var/www/build

RUN composer clearcache

RUN cd /var/www/build \
  && composer install --no-dev \
  && composer dump -o \
  && yarn \
  && yarn build:production \
  && rm -rf assets/scss node_modules bash \
  && find . -type d -name 'node_modules' -exec rm - rf {} + \
  && find . -type d -name '*.git' -exec rm -rf {} + \
  && find . -type f -name '*.map' -exec rm {} + \
  && find . -type f -name '*.json' -exec rm {} + \
  && find . -type f -name '*.rb' -exec rm {} + \
  && find . -type f -name 'composer*' -exec rm {} + \
  && find . -type f -name 'README*' -exec rm {} + \
  && find . -type f -name '*.lock' -exec rm {} + \
  && find . -type f -name '*.mix.*' -exec rm {} + \
  && find . -type f -name '*.txt' -exec rm {} + \
