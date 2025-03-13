# Use the official PHP image with Apache
FROM php:8.2-apache

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache's mod_rewrite (useful for clean URLs)
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy all project files to the container
COPY . /var/www/html/

# Give proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 for Apache
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
