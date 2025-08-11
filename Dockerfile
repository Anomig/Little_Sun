FROM php:8.3-apache
RUN a2enmod rewrite
RUN docker-php-ext-install pdo_mysql   # <— deze regel toevoegen
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf
WORKDIR /var/www/html
COPY . /var/www/html
