ARG PHP_VERSION=8.3

FROM php:${PHP_VERSION}-fpm-alpine

## Make php ini
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

## Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && mv composer.phar /usr/local/bin/composer

## Config user
ARG USER_ID=1000
ENV USER_ID=${USER_ID}
ARG GROUP_ID=1000
ENV GROUP_ID=${GROUP_ID}

# ensure www-data user exists
RUN set -eu; \
    addgroup -g ${USER_ID} csdev; \
    adduser -D -u ${USER_ID} -G csdev csdev;

# Default workdir
WORKDIR /var/www

## Install Ext
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN install-php-extensions soap pcntl bcmath gd exif sockets zip xdebug redis intl pdo_mysql mysqli

USER csdev



CMD ["php-fpm"]
