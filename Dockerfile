FROM php:apache
RUN apt-get update && docker-php-ext-install -j$(nproc) iconv mysqli mbstring opcache pdo pdo_mysql
RUN a2enmod rewrite
RUN pecl install redis && docker-php-ext-enable redis
COPY config/php.ini /usr/local/etc/php/
