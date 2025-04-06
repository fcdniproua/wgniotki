FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    nginx \
    supervisor

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents
COPY . /var/www

# Configure Nginx
COPY ./docker/nginx/conf.d/app.conf /etc/nginx/sites-available/default
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

# Install app dependencies and build
RUN composer install --optimize-autoloader --no-dev
RUN npm install
RUN npm run build

# Configure supervisor
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Set permissions
RUN chmod -R 777 /var/www/storage /var/www/bootstrap/cache

# Create startup script
RUN echo '#!/bin/bash\n\
sed -i "s/listen = 127.0.0.1:9000/listen = 9000/" /usr/local/etc/php-fpm.d/www.conf\n\
sed -i "s/listen 80;/listen $PORT;/" /etc/nginx/sites-available/default\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
supervisord -c /etc/supervisor/conf.d/supervisord.conf\n\
' > /var/www/start.sh && chmod +x /var/www/start.sh

# Expose the port specified by Render
EXPOSE $PORT

# Start both nginx and php-fpm with supervisor
CMD ["/var/www/start.sh"]