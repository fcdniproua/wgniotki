<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="/">
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <title>Usuwanie wgnieceń bez lakierowania | Profesjonalna naprawa karoserii</title>

    <meta name="description" content="Specjalizujemy się w bezinwazyjnym usuwaniu wgnieceń karoserii metodą PDR. Szybko, skutecznie i bez potrzeby lakierowania. Umów się już dziś!">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Usuwanie wgnieceń bez lakierowania">
    <meta property="og:description" content="Profesjonalna naprawa karoserii bez potrzeby lakierowania. Sprawdź nasze usługi!">
    <meta property="og:url" content="https://usuwanie-wgniecen.pro/">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://usuwanie-wgniecen.pro/assets/img/logo_v4.jpg">
    <link rel="canonical" href="https://usuwanie-wgniecen.pro/">
    <link rel="icon" sizes="32x32"  type="image/svg" href="/favicon.svg">
    <link rel="icon" sizes="16x16"  type="image/svg" href="/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon.svg">
    <!-- Вставити в <head> -->
    <script src="https://web.cmp.usercentrics.eu/modules/autoblocker.js"></script>
    <script id="usercentrics-cmp" src="https://web.cmp.usercentrics.eu/ui/loader.js" data-settings-id="150J0GIKDuPMLE" async></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-02NE65J2SL"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){ dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-02NE65J2SL');
    </script>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-T4LT364F');</script>
</head>
<body>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T4LT364F"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<div id="app"></div>
</body>
</html>
# server {
#    listen 80;
#    server_name localhost;
#    root /var/www/public;
#    index index.php index.html;
#
#   location / {
#        try_files $uri $uri/ /index.php?$query_string;
#   }
#
#    location ~ \.php$ {
#        fastcgi_pass laravel_app:9000;
#        fastcgi_index index.php;
#        include fastcgi_params;
#        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
#        fastcgi_param PATH_INFO $fastcgi_path_info;
#    }
#
#    location ~ /\.ht {
#        deny all;
#    }
#}

server {
listen 80;
server_name _;

root /var/www/public;
index index.php index.html;

location / {
try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
include fastcgi_params;
fastcgi_pass laravel_app:9000;
fastcgi_index index.php;
fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
}
}

