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
    zip \
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

RUN apt-get update && apt-get install -y default-mysql-client

# Install Composer
RUN cd /var/www
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN cd /var/www/html


# Set permissions for entrypoint script
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
RUN chmod +x /var/www/html/entrypoint.sh

COPY . /var/www/html
# Expose port 8000 and start php-fpm server
EXPOSE 8000

#CMD ["/var/www/html/entrypoint.sh"]
CMD ["entrypoint.sh"]
