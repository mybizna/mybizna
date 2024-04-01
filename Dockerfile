# Use the official PHP image as base
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip mbstring exif pcntl bcmath xml

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clone the MyBizna ERP system from GitHub with depth of 1
RUN git clone --depth 1 https://github.com/mybizna/mybizna .

# Install PHP dependencies
RUN composer install --no-interaction

# Copy .env file
COPY .env.example .env

# Generate application key
RUN php artisan key:generate

# Run migrations
RUN php artisan migrate --force

# Expose port 9000 and start php-fpm server
EXPOSE 80
CMD ["php-fpm"]
