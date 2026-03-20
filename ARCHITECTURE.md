# Architecture: http_build_url

## Purpose
A pure-PHP polyfill for the PECL `http_build_url()` function. Provides URL construction and manipulation (replacing parts, joining paths, merging query strings, stripping components) without requiring the PECL HTTP extension.

## Directory Structure
```
src/
  http_build_url.php   # Defines the http_build_url() function if not already provided by PECL
tests/
  HttpBuildUrlTest.php # PHPUnit tests covering all flag combinations
  bootstrap.php        # Test bootstrap
```

## Key Design Decisions
- **Conditional definition** — the function is only defined if `!function_exists('http_build_url')`, ensuring the polyfill gracefully defers to the native PECL implementation when available.
- **Bitmask flags** — behaviour is controlled by OR-composable `HTTP_URL_*` constants matching the PECL API (REPLACE, JOIN_PATH, JOIN_QUERY, STRIP_USER, STRIP_PASS, etc.).
- **parse_url / http_build_query interop** — input can be a URL string or an array (as returned by `parse_url()`), and query strings are merged using `http_build_query()`.
- **`$new_url` out parameter** — mirrors the PECL API by populating a by-reference array with the parsed components of the resulting URL.

## Extension Points
- No extension points needed — this is a drop-in compatibility shim.
- To add custom URL transformation logic, wrap `http_build_url()` calls in a higher-level service class.

## Dependency Flow
```
Caller code
  └─ http_build_url($url, $parts, $flags, &$new_url)
       ├─ parse_url() — normalise string input to component arrays
       ├─ Flag checks — apply STRIP/JOIN/REPLACE logic per component
       └─ String assembly — scheme + auth + host + port + path + query + fragment
```
