FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql zip \
    && docker-php-ext-install dom xml

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

CMD ["php-fpm"]
