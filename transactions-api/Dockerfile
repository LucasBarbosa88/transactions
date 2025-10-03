FROM php:8.4-apache

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libmagickwand-dev --no-install-recommends \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && rm -rf /var/lib/apt/lists/*

# Ativar mod_rewrite (necessário para Laravel routes)
RUN a2enmod rewrite

# Definir document root como "public" (Laravel)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiar código do Laravel
COPY . /var/www/html/

# Permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Instalar dependências Laravel
RUN composer install --optimize-autoloader --no-dev

EXPOSE 80
