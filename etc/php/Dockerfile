FROM php:8.3.11-fpm

ARG WWWGROUP=www-data
ARG WWWUSER=www-data

# install ext for project
RUN apt-get update && apt-get install -y \
      git \
      curl \
      sudo \
      cron \
      zip \
      unzip \
      vim \
      ca-certificates \
      supervisor \
      libpng-dev \
      libzip-dev \
      libonig-dev \
      libjpeg62-turbo-dev \
      libfreetype6-dev \
      build-essential \
      locales \
      jpegoptim optipng pngquant gifsicle

RUN apt-get clean 
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# install pdo - mysql 
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Add docker php ext repo
ADD https://github.com/mlocati/docker-php-extension-installer/releases/download/2.5.2/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && install-php-extensions mbstring pdo_mysql zip exif pcntl gd memcached fileinfo mysqli sodium xsl

# install composer and running composer install
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/
COPY . .

RUN mkdir -p /var/log/supervisor/ /var/www/be/storage/logs/

# Update
RUN apt-get update

COPY --chown=$WWWGROUP:$WWWUSER . /var/www/
RUN chown -R $WWWGROUP:$WWWUSER /var/www /var/log/supervisor /var/www/be/bootstrap/cache /var/www/be/storage /var/www/be/storage/logs
RUN chmod -R 775 /var/www/be/bootstrap/cache /var/www/be/storage /var/www/be/storage/logs

RUN cd be && composer install

COPY etc/php/supervisor/ /etc/supervisor/
COPY etc/php/conf.d/docker.ini /usr/local/etc/php/conf.d/docker.ini

EXPOSE 8000

USER $WWWUSER

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
# untuk pertama kali, masuk ke conteiner dengan user root, lalu jalankan perintah ini
# cd be && composer install && sudo chown -R $USER:www-data storage && sudo chown -R $USER:www-data bootstrap/cache && sudo chmod -R 775 bootstrap/cache && sudo chmod -R 775 storage