<?php
require 'vendor/autoload.php';

$client = new \GuzzleHttp\Client();

try {
    $response = $client->post('http://127.0.0.1:8000/api/login', [
        'json' => [
            'email' => 'admin@example.com',
            'password' => 'secretpassword'
        ]
    ]);
    
    echo "STATUS: " . $response->getStatusCode() . "\n";
    echo "BODY: " . $response->getBody() . "\n";
} catch (\GuzzleHttp\Exception\ClientException $e) {
    echo "ERROR HTTP " . $e->getResponse()->getStatusCode() . "\n";
    echo $e->getResponse()->getBody() . "\n";
}
