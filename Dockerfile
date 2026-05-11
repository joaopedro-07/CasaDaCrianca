FROM php:8.2-apache

# Instala dependências
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev

# Instala extensões PHP
RUN docker-php-ext-install zip pdo pdo_mysql

# Habilita mod_rewrite
RUN a2enmod rewrite

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia projeto
COPY . /var/www/html/

WORKDIR /var/www/html

# Instala dependências do composer
RUN composer install

# Permissões
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80