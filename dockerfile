FROM php:8.0-apache

RUN apt-get clean
RUN apt-get update
RUN apt-get install -y libzip-dev \
			zip \ 
			git \
			libpq-dev

RUN docker-php-ext-install zip
RUN pecl install mongodb && docker-php-ext-enable mongodb
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/php.ini

RUN a2enmod rewrite

COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html

COPY . .

RUN ["composer","install"]