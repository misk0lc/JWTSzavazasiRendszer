<?php

return [
    'secret' => env('JWT_SECRET'),
    'algo' => env('JWT_ALGO', 'HS256'),
    'ttl' => env('JWT_TTL', 60),
    // Additional provider settings are configured when installing the package
];
