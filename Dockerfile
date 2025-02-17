FROM php:cli-alpine3.19

RUN apk update && apk upgrade

RUN apk add --no-cache \
    composer \
    nodejs \
    npm \
    yarn

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=node:20 /usr/local/bin/node /usr/bin/node
COPY --from=node:20 /usr/local/bin/npm /usr/bin/npm

RUN yarn --version || npm install -g yarn@1.22.4

COPY --chown=www-data:www-data . /var/www/build

RUN composer clear-cache

RUN cd /var/www/build && \
    composer install --no-dev --prefer-dist --optimize-autoloader && \
    composer dump-autoload -o && \
    yarn && \
    yarn build:production

RUN rm -rf /var/www/build/assets/scss /var/www/build/node_modules /var/www/build/bash && \
    find /var/www/build -type d -name 'node_modules' -exec rm -rf {} + && \
    find /var/www/build -type d -name '*.git*' -exec rm -rf {} + && \
    find /var/www/build -type f \( -name '.*' -o -name '*.map' -o -name 'Dockerfile*' -o -name 'task-definition.json' -o \
                                  -name '*.json' -o -name '*.rb' -o -name 'composer*' -o -name 'README*' -o \
                                  -name '*.lock' -o -name '*.mix.*' -o -name '*.txt' \) -exec rm {} +
