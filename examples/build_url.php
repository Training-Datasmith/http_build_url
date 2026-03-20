<?php

declare(strict_types=1);

/**
 * Example: build and manipulate URLs using http_build_url().
 *
 * Run from the http_build_url project root:
 *   php examples/build_url.php
 */

require __DIR__ . '/../vendor/autoload.php';

// --- Replace the path of an existing URL ---
$base = 'https://example.com/old/path?foo=bar';
$result = http_build_url($base, ['path' => '/new/path'], HTTP_URL_REPLACE);
echo $result . "\n";
// https://example.com/new/path?foo=bar

// --- Join query strings from two URLs ---
$result = http_build_url(
    'https://example.com/search?q=php',
    ['query' => 'page=2'],
    HTTP_URL_JOIN_QUERY
);
echo $result . "\n";
// https://example.com/search?q=php&page=2

// --- Strip authentication credentials ---
$result = http_build_url(
    'https://user:secret@example.com/secure',
    [],
    HTTP_URL_STRIP_AUTH
);
echo $result . "\n";
// https://example.com/secure

// --- Get the parsed components of the result ---
$new_url = [];
http_build_url('https://example.com/path', ['fragment' => 'section'], HTTP_URL_REPLACE, $new_url);
print_r($new_url);
