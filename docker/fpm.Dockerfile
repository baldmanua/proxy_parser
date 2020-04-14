FROM php:fpm

RUN apt-get update \
&& apt-get install -y \
    libzip-dev \
    cron \
    mc \
&& docker-php-ext-install pdo pdo_mysql zip

# Create the log file
RUN touch /var/log/schedule.log
RUN chmod 0777 /var/log/schedule.log

# Add crontab file in the cron directory
ADD /docker/cron/scheduler /etc/cron.d/scheduler

# Run the cron
RUN crontab /etc/cron.d/scheduler
CMD ["cron", "-f"]
