FROM php:8.1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer 

#COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
#COPY . /app/
WORKDIR /app/

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp

RUN apt-get update \
  && apt-get install -y libzip-dev wget cron --no-install-recommends \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install zip;

COPY cron /etc/cron.d/sample

#CMD bash -c "cd /app && composer install && php -a"

# Running crontab
RUN crontab /etc/cron.d/sample

# owner can read and write into the crontab, group and others can read it
RUN chmod 0644 /etc/cron.d/sample

# Creating entry point for cron
ENTRYPOINT ["cron", "-f"]