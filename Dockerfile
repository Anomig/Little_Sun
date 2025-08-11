FROM php:8.3-apache
RUN a2enmod rewrite
# heb je MySQL? laat deze regel aan; anders mag ze weg
RUN docker-php-ext-install pdo_mysql

# Render geeft een dynamische poort -> Apache daarop laten luisteren
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf

WORKDIR /var/www/html
COPY . /var/www/html
