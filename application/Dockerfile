FROM serversideup/php:8.4-fpm-nginx

ARG FLUX_USERNAME
ARG FLUX_PASSWORD

USER root

# Set working directory
WORKDIR /var/www/html

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_23.x | bash - \
    && apt-get install -y nodejs

# Copy the rest of the app
COPY . .

RUN npm install && npm run build

USER www-data
