<?php
$filePath = 'lang/ar.json';
if (!file_exists($filePath)) {
    die("File not found: $filePath");
}

$content = file_get_contents($filePath);
// Since the file has duplicate keys, json_decode will keep the LAST occurrence by default.
// This is actually what we want for some of my new translations if they were intended as overrides, 
// but mostly we just want a clean unique list.
$json = json_decode($content, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("JSON Decode Error: " . json_last_error_msg());
}

// Ensure unique keys (PHP arrays naturally handle this by overwriting)
// We will sort them alphabetically for better maintenance
ksort($json);

$newContent = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
file_put_contents($filePath, $newContent);
echo "Deduplicated and sorted ar.json successfully.";
