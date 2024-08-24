FROM php:8.0-apache

RUN apt-get clean
RUN apt-get update
RUN apt-get install -y supervisor \
			cron \
			libzip-dev \
			zip \ 
			git \
			libpq-dev \
			libcurl4-openssl-dev \
			pkg-config \ 
			libssl-dev

RUN docker-php-ext-install zip
RUN pecl install mongodb && docker-php-ext-enable mongodb

RUN a2enmod rewrite

RUN echo "* * * * * root php /var/www/artisan schedule:run >> /var/log/cron.log 2>&1" >> /root/crontab
COPY ./supervisor.conf /etc/supervisor/supervisor.conf
RUN mkdir /etc/supervisor/logs
RUN touch /var/log/cron.log
RUN crontab /root/crontab

COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html

COPY . .

RUN composer install

CMD cron && tail -f /var/log/cron.log  & /usr/bin/supervisord -c /etc/supervisor/supervisor.conf