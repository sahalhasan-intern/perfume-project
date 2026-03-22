<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$credentials = [
    'email' => 'admin@example.com',
    'password' => 'secretpassword', // default test postman
];

if (!$token = auth('api')->attempt($credentials)) {
    echo "NO_MATCH\n";
} else {
    echo "TOKEN: " . $token . "\n";
}
