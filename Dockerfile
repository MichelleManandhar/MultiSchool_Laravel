FROM php:7
RUN apt-get update -y && apt-get install -y openssl zip unzip git libfreetype6-dev libjpeg62-turbo-dev libpng-dev libzip-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mbstring pdo_mysql mysqli zip && docker-php-ext-configure zip --with-libzip && docker-php-ext-install zip
RUN useradd ww-data
WORKDIR /app
COPY ./composer.json /app
#Expecting error but dependencies will be downloaded in this layer. So need to redo composer install after all files are copied
RUN composer install; exit 0
COPY . /app
COPY .env.prod /app/.env
RUN composer install
RUN php artisan key:generate
CMD php artisan migrate
CMD php artisan config:cache
CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181
