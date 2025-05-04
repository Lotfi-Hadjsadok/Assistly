FROM serversideup/php:8.4-fpm-nginx

ARG FLUX_USERNAME
ARG FLUX_PASSWORD

USER root

# Set working directory
WORKDIR /var/www/html

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_23.x | bash - \
    && apt-get install -y nodejs

# Copy only necessary files for dependencies install
COPY composer.json composer.lock package.json package-lock.json auth.json ./

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy the rest of the app
COPY . .

RUN npm install && npm run build

USER www-data
