FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy all project files into container
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
