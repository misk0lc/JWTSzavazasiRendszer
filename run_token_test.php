<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'admin@example.com')->first();
if (!$user) {
    echo "Admin user not found\n";
    exit(1);
}

$token = PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth::fromUser($user);
echo "TOKEN: $token\n";
echo "DECODED ID: " . PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth::getUserIdFromToken($token) . "\n";
