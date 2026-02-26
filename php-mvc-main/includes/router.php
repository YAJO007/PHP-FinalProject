<?php

declare(strict_types=1);

const ALLOW_METHODS = ['GET', 'POST'];
const INDEX_URI = '';
const INDEX_ROUTE = 'home';

function normalizeUri(string $uri): string
{
    $path = parse_url($uri, PHP_URL_PATH) ?: '';
    $base = dirname($_SERVER['SCRIPT_NAME']);
    
    if ($base !== '/' && strpos($path, $base) === 0) {
        $path = substr($path, strlen($base));
    }

    $path = strtolower(trim($path, '/'));
    return $path === INDEX_URI ? INDEX_ROUTE : $path;
}

function notFound()
{
    http_response_code(404);
    renderView('404');
    exit;
}

function getFilePath(string $uri): string
{
    return ROUTE_DIR . '/' . normalizeUri($uri) . '.php';
}

function dispatch(string $uri, string $method): void
{
    $uri = normalizeUri($uri);

    if (!in_array(strtoupper($method), ALLOW_METHODS)) {
        notFound();
    }

    $file = getFilePath($uri);
    if (file_exists($file)) {
        include($file);    } else {
        notFound();
    }
}