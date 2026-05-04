<?php

// Memuat autoload dari composer
require __DIR__ . '/../vendor/autoload.php';

// Memuat aplikasi Laravel dari bootstrap/app.php
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Menangani request yang masuk
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);