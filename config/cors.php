<?php

return [

    'paths' => ['add-product'],          // Define the paths for which CORS is applied
    'allowed_methods' => ['*'],          // Allow all HTTP methods (GET, POST, PUT, DELETE, etc.)
    'allowed_origins' => ['*'],          // Allow all origins (replace '*' with specific origins if needed)
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],          // Allow all headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,

];
