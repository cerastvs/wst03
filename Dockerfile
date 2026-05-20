FROM php:8.2-apache

RUN a2enmod rewrite

RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

WORKDIR /var/www/html/WS03
RUN composer install --no-dev --no-interaction --optimize-autoloader

WORKDIR /var/www/html

EXPOSE 80
