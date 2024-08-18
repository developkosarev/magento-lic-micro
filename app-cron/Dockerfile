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
#ENTRYPOINT ["cron", "-f"]



# Adding crons from current directory
ADD crons /etc/cron.d/crons

# Adding entrypoint.sh from current directory
ADD entrypoint.sh /entrypoint.sh

ADD display_environment_variable.sh /var/scripts/

# Adding executable permissions
RUN chmod +x /entrypoint.sh /etc/cron.d/crons /var/scripts/display_environment_variable.sh

# Setting sample ENV variable
ENV TZ=Europe/Berlin

# Create a new crontab file
RUN touch /etc/cron.d/crontab

# Grep all env variable and COPY to crontab file
RUN printenv | sed 's/^\(.*\)$/\1/g' > /etc/cron.d/crontab

# Now append all commands in crons file to crontab file
RUN cat /etc/cron.d/crons >> /etc/cron.d/crontab
RUN cat /etc/cron.d/sample >> /etc/cron.d/crontab 

# Delete the crons file
RUN rm -f /etc/cron.d/crons

ENTRYPOINT /entrypoint.sh