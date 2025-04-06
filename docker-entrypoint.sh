#!/bin/sh
# Замінити змінну PORT в конфігурації Nginx
envsubst < /etc/nginx/conf.d/app.conf.template > /etc/nginx/conf.d/app.conf

## Запустити Nginx
#nginx -g 'daemon off;'
