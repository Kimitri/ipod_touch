FROM php:8.2-apache
COPY ./weather/ /var/www/html/weather/
COPY ./index.html /var/www/html/index.html

RUN apt-get update; \
    apt-get install -y libmagickwand-dev; \
    apt-get install -y imagemagick; \
    pecl install imagick; \
    docker-php-ext-enable imagick;

RUN mkdir -p /var/www_storage/cache/weather/ && \
    chown -R www-data:www-data /var/www_storage/ && \
    chmod -R 777 /var/www_storage/


EXPOSE 80

