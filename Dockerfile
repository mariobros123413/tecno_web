# Usamos una imagen base de PHP con Apache
FROM php:8.1-apache

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias de sistema necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl

# Instalar extensiones de PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar los archivos del proyecto
COPY . .

# Instalar dependencias del proyecto
RUN composer install

# Copiar y configurar el archivo de entorno
COPY .env.example .env

# Dar permisos de escritura a las carpetas necesarias
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer el puerto 80
EXPOSE 80

# Ejecutar el comando para iniciar el servidor
CMD ["apache2-foreground"]
