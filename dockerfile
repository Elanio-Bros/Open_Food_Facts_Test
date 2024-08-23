FROM php:8.0-apache

RUN apt-get clean
RUN apt-get update
RUN apt-get install -y libzip-dev \
			zip \ 
			git \
			libpq-dev \
			libcurl4-openssl-dev \
			pkg-config \ 
			libssl-dev

RUN docker-php-ext-install zip
RUN pecl install mongodb && docker-php-ext-enable mongodb

RUN a2enmod rewrite

COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html

COPY . .

RUN ["composer","install"]