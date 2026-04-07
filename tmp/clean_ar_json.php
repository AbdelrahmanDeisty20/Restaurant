<?php
$path = 'lang/ar.json';
$json = json_decode(file_get_contents($path), true);
if (json_last_error() === JSON_ERROR_NONE) {
    file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    echo "Successfully cleaned up ar.json\n";
} else {
    echo "Error decoding JSON: " . json_last_error_msg() . "\n";
}
