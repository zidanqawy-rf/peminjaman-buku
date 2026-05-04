<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->registered(function ($app) {
        // PERBAIKAN KRUSIAL: Memastikan folder storage ada di /tmp agar writable
        $app->useStoragePath('/tmp');
        
        // Memastikan folder session dan views tersedia di folder tmp
        if (!is_dir('/tmp/framework/views')) {
            mkdir('/tmp/framework/views', 0755, true);
        }
        if (!is_dir('/tmp/framework/sessions')) {
            mkdir('/tmp/framework/sessions', 0755, true);
        }
    })
    ->create();