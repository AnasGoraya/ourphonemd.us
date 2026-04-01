<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Test email from Laravel', function($message) {
        $message->to('anasgoraya99@gmail.com')->subject('Test Email');
    });
    echo "Email sent successfully\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
