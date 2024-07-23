# Use the official PHP 8.1 Apache image as base
FROM php:8.1-apache

# Install additional dependencies
RUN apt-get update && \
    apt-get install -y \
        zip \
        git \
        default-mysql-client && \
    rm -rf /var/lib/apt/lists/*


# Enable PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Expose port 80 (default for Apache)
EXPOSE 80

# Set permissions for entrypoint script
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set entrypoint
ENTRYPOINT ["entrypoint.sh"]
