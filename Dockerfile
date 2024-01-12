FROM php:8.0-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y
# Install PDO MySQL Extension
RUN docker-php-ext-install pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

# Copy your application files to the container
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html/

# Start Apache
CMD ["apache2-foreground"]