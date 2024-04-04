# Use the official PHP image as base
FROM ubuntu:22.04

ENV DEBIAN_FRONTEND noninteractive

# ubuntu setup
RUN apt update -y
RUN apt upgrade -y 

RUN apt install -y software-properties-common
RUN apt update -y

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt install -y \
    git \
    apache2 \
    curl \
    php \
    php-mysql \
    php-imap \
    php-ldap \
    php-xml \
    php-curl \
    php-mbstring \
    php-zip \
    php-tokenizer \
    openssl \
    libapache2-mod-php 

COPY . /var/www/html

# Install Composer
RUN cd /var/www
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN cd /var/www/html

RUN rm -rf Modules/* && rm -rf composer.lock

# Copy .env file
COPY .env.example .env

# Modify .env file to use localhost as MySQL host without password
RUN sed -i 's/DB_HOST=.*/DB_HOST=127.0.0.1/g' .env && \
    sed -i 's/DB_USERNAME=.*/DB_USERNAME=root/g' .env && \
    sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=/g' .env

# Set permissions for entrypoint script
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
RUN chmod +x /var/www/html/entrypoint.sh

# Expose port 8000 and start php-fpm server
EXPOSE 8000

#CMD ["/var/www/html/entrypoint.sh"]
CMD ["entrypoint.sh"]
