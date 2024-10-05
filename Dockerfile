FROM php:8.1-fpm-alpine

# Install system dependencies
RUN apk add --no-cache nginx supervisor

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Node.js
RUN apk add --no-cache nodejs npm

# Install PHP and JS dependencies
RUN composer install --optimize-autoloader --no-dev
RUN npm install
RUN npm run build

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port 80
EXPOSE 80

# Start supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

RUN chown -R www-data:www-data /var/www