<?php

// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Check if Laravel bootstrap exists
$bootstrap = __DIR__ . '/../public/index.php';

if (!file_exists($bootstrap)) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Laravel entry point not found',
        'looking_for' => $bootstrap,
        'current_dir' => __DIR__,
        'files_in_dir' => scandir(__DIR__ . '/..'),
    ]);
    exit(1);
}

// Check if vendor exists
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Composer dependencies not found',
        'message' => 'vendor/autoload.php is missing',
    ]);
    exit(1);
}

try {
    // Forward request to Laravel
    require $bootstrap;
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Laravel Bootstrap Error',
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString(),
    ]);
    exit(1);
}
