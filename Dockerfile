FROM php:8.2-fpm

# Cài đặt các dependency
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Tạo thư mục làm việc
WORKDIR /var/www

# Copy code vào container
COPY . .

# Phân quyền
RUN chown -R www-data:www-data /var/www

# Expose port
EXPOSE 9000

CMD ["php-fpm"]
