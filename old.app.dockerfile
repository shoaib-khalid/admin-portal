FROM php:7.4-fpm
 
RUN apt-get update && apt-get install -y libmcrypt-dev mariadb-client libpng-dev libjpeg-dev libfreetype6-dev zlib1g-dev libjpeg62  \
  && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install pdo_mysql gd
    
WORKDIR /var/www