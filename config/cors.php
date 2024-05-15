<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | For more detailed information: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*'],  // Paths that should be accessible from a different origin. Adjust if necessary.

    'allowed_methods' => ['*'],  // Methods that should be allowed when accessing the paths.

    'allowed_origins' => ['http://localhost:3000'],  // Origins that are allowed to access the API.

    'allowed_origins_patterns' => [],  // Patterns that are allowed.

    'allowed_headers' => ['*'],  // Headers that should be allowed in the requests.

    'exposed_headers' => [],  // Headers that should be exposed to the browser.

    'max_age' => 0,  // The maximum amount of seconds the results can be cached.

    'supports_credentials' => false,  // Indicates whether the request can include user credentials like cookies, HTTP authentication or client-side SSL certificates.
];
