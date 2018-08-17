FROM php:apache
RUN apt-get update && docker-php-ext-install -j$(nproc) iconv mysqli mbstring opcache pdo pdo_mysql
RUN a2enmod rewrite
RUN pecl install redis && docker-php-ext-enable redis
COPY config/php.ini /usr/local/etc/php/
# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && php composer-setup.php && php -r "unlink('composer-setup.php');" && mv composer.phar /usr/local/bin/composer
# install packages
RUN apt-get -y install git
