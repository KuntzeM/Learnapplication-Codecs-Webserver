FROM php:5.6-apache


WORKDIR /var/www/html/


# according to https://docs.docker.com/engine/userguide/eng-image/dockerfile_best-practices/
RUN apt-get update && apt-get install -y \
    zip \
    git \
    php5-mysql \
 && rm -rf /var/lib/apt/lists/*



RUN docker-php-source extract \
&& docker-php-ext-install pdo_mysql \
&& docker-php-source delete


 # Bundle app source
COPY . /var/www/html/
COPY dockerphp.ini /usr/local/etc/php/php.ini

RUN php composer.phar update

# TODO: run only if needed

# php artisan migrate:install
# RUN php artisan migrate:refresh --seed


# TODO: check permission problem
RUN chmod -R 777 /var/www/html/

CMD apache2-foreground

