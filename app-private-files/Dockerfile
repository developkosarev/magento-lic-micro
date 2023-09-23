FROM php:8.1

ARG APP_ID=1000
# [-g] group id, [app] name of group
RUN groupadd -g "$APP_ID" app
# [-g] group id, [-u] user id, [-d] home directorie, [-s] shell, [app] username
RUN useradd -g "$APP_ID" -u "$APP_ID" -d /var/www -s /bin/bash app


# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer 

#COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
#COPY . /app/
#WORKDIR /app/

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp

RUN apt-get update \
  && apt-get install -y libzip-dev libicu-dev libxml2-dev wget cron supervisor --no-install-recommends \
  && apt-get install -y \
    mc \
    procps \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install channel://pecl.php.net/xmlrpc-1.0.0RC3

RUN docker-php-ext-configure intl
RUN docker-php-ext-install zip pdo pdo_mysql opcache intl
RUN docker-php-ext-enable xmlrpc

COPY ./supervisor.conf /etc/supervisor/conf.d/supervisor.conf

#USER app:app
#WORKDIR /var/www/html

#CMD bash -c "cd /app && composer install && php -a"
#CMD ["sh", "-c", "/usr/sbin/cron -f"]
CMD /usr/bin/supervisord