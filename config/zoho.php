<?php

return [
    'client_id' => env('ZOHO_CLIENT_ID', ''),
    'client_secret' => env('ZOHO_CLIENT_SECRET', ''),
    'redirect_uri' => env('ZOHO_REDIRECT_URI', ''),
    'current_user_email' => env('ZOHO_CURRENT_USER_EMAIL', ''),
    'api_domain' => env('ZOHO_API_DOMAIN', 'https://accounts.zoho.com'),
    'access_type' => 'offline',
    'persistence_handler_class' => 'ZCRMFilePersistence',
    'token_persistence_path' => storage_path('app/zoho/oauth'),
];