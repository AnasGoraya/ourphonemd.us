<?php
$log = 'storage/logs/laravel.log';
if (file_exists($log)) {
    $content = file_get_contents($log, false, null, max(0, filesize($log) - 100000));
    file_put_contents('error_report.txt', $content);
    echo "Log extracted to error_report.txt";
} else {
    echo "Log file not found";
}
