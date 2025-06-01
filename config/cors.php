<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or “CORS”. This determines what cross-origin operations may execute
    | in web browsers. You’re free to adjust these settings as needed.
    |
    */

    'paths' => [
        'api/*',          // apply CORS to all API routes
        'sanctum/csrf-cookie',
    ],

    'allowed_methods' => [
        '*',              // allow all HTTP methods (GET, POST, PUT, DELETE, etc.)
    ],

    'allowed_origins' => [
        'http://localhost:8000',   // Your front-end origin(s)
        'http://127.0.0.1:8000',
        // e.g. 'https://your-domain.test',
    ],

    'allowed_origins_patterns' => [
        // Patterns (useful for dynamic subdomains), e.g.:
        // '*.your-domain.test',
    ],

    'allowed_headers' => [
        '*',              // allow all headers (including X-CSRF-TOKEN)
    ],

    'exposed_headers' => [
        // e.g. 'Link',
    ],

    'max_age' => 0,      // how long the results of a preflight request can be cached

    /*
    |--------------------------------------------------------------------------
    | Supports Credentials
    |--------------------------------------------------------------------------
    |
    | Whether or not the response to the request can be exposed when the
    | credentials flag is true. When used in combination with allow_origins
    | that are not '*', this will set Access-Control-Allow-Credentials.
    |
    */

    'supports_credentials' => true,

];
