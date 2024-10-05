# Utiliser PHP 8.1 FPM basé sur Alpine
FROM php:8.1-fpm-alpine AS base

# Installer les dépendances système
RUN apk add --no-cache nginx supervisor git curl unzip nodejs npm

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Copier Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier package.json et package-lock.json en premier
COPY package.json package-lock.json ./

# Installer les dépendances Node.js
RUN npm install

# Copier le reste du projet
COPY . .

# Lancer le build des fichiers frontend
RUN npm run build

# Installer les dépendances PHP avec Composer
RUN composer install --optimize-autoloader --no-dev

# Changer les permissions des fichiers
RUN chown -R www-data:www-data /var/www

# Configuration Nginx et Supervisor
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Exposer le port 80 pour le serveur web
EXPOSE 80

# Lancer supervisord au démarrage du conteneur
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
