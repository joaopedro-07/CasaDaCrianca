FROM php:8.2-apache

# Atualiza pacotes
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev

# Instala extensões PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql zip

# Habilita rewrite
RUN a2enmod rewrite

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia arquivos
COPY . /var/www/html/

WORKDIR /var/www/html

# Instala dependências
RUN composer install

# Permissões
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80