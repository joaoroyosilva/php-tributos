<?php
// This array has a single file but could whole the contents of an entire directory.
$files = [
    dirname(__DIR__) . '/AcmeCache.php',
];

foreach ($files as $file) {
    if (file_exists($file)) {
        require_once $file;
    }
}
