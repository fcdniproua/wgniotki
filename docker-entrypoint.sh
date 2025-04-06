#!/bin/sh

# Замінюємо PORT у конфігурації nginx
if [ ! -z "$PORT" ]; then
    sed -i "s/listen 80/listen $PORT/g" /etc/nginx/conf.d/app.conf
fi

# Запускаємо оригінальний entrypoint з nginx
exec /docker-entrypoint.sh nginx -g 'daemon off;'