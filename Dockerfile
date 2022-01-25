FROM php:7.4-apache

# gmp is required by MadelineProto (read README.md)
# gmp not installed by default in php:8-apache
# RUN apt update && apt-get install -y libgmp-dev
# RUN docker-php-ext-install gmp

RUN apt update && apt install -y git zip unzip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
#RUN php -r "if (hash_file('sha384', 'composer-setup.php') === #'756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo #'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN apt-get update && apt-get install -y \
libmcrypt-dev \
mariadb-client \
libpng-dev \
libjpeg-dev \
libfreetype6-dev \
zlib1g-dev \
libzip-dev \
libgd-dev \
zip

RUN docker-php-ext-install pdo pdo_mysql zip
	
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install gd
	
# enable apache2 rewrite module
RUN a2enmod rewrite

ARG PACKAGE_NAME="adminportal.tar.gz"
ARG APACHE_DOCUMENT_ROOT="/var/www/html/public"

ENV PACKAGE_NAME=${PACKAGE_NAME}
ENV APACHE_DOCUMENT_ROOT=${APACHE_DOCUMENT_ROOT}

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# COPY $PACKAGE_NAME /var/www/html/$PACKAGE_NAME
# RUN tar -xvzf /var/www/html/$PACKAGE_NAME -C /var/www/html/
# RUN chown www-data:www-data
EXPOSE 80