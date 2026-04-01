<?php
$file = __DIR__ . '/../storage/logs/laravel.log';
$chunkSize = 50000;
$fp = fopen($file, 'r');
fseek($fp, -$chunkSize, SEEK_END);
$content = fread($fp, $chunkSize);
fclose($fp);

// Find the last "local.ERROR"
$matches = [];
preg_match_all('/local\.ERROR: (.*?)(?=\n\[)/s', $content, $matches);

if (!empty($matches[0])) {
    $lastErrors = array_slice($matches[0], -2); // Get last 2 errors
    foreach ($lastErrors as $error) {
        echo "--------------------------------------------------\n";
        echo substr($error, 0, 1000) . "\n...\n"; // Print first 1000 chars of the error
    }
} else {
    echo "No recent errors found in the last $chunkSize bytes.\n";
    // Just print the end of file
    echo substr($content, -2000);
}
