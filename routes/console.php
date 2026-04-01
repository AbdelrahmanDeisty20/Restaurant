<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

Schedule::command('queue:work --max-time=30')
    ->everyMinute()
    ->withoutOverlapping();

// Clean up expired password reset tokens hourly
Schedule::command('auth:clear-resets')->hourly();

// Clean up expired API tokens daily to keep the database light
Schedule::command('sanctum:prune-expired --hours=24')->daily();

use Illuminate\Support\Facades\Mail;

Artisan::command('mail:test {email}', function ($email) {
    $host = config('mail.mailers.smtp.host');
    $port = config('mail.mailers.smtp.port');
    $encryption = config('mail.mailers.smtp.encryption');

    $this->info("--- Mail Configuration ---");
    $this->line("Host: $host");
    $this->line("Port: $port");
    $this->line("Encryption: $encryption");
    $this->line("From: " . config('mail.from.address'));
    $this->line("Username: " . config('mail.mailers.smtp.username'));
    $this->info("--------------------------");

    $this->info("Checking connection to $host:$port...");
    
    // Check if port is reachable
    $connection = @fsockopen($host, $port, $errno, $errstr, 10);
    if (is_resource($connection)) {
        $this->info("✅ TCP Connection successful!");
        fclose($connection);
    } else {
        $this->error("❌ TCP Connection failed: $errstr ($errno)");
        $this->line("Possible reasons: Port blocked by Hostinger, incorrect host, or DNS issue.");
    }

    $this->info("Attempting to send a raw test email to $email...");
    try {
        Mail::raw('This is a test email from your Laravel application to verify SMTP settings.', function ($message) use ($email) {
            $message->to($email)
                    ->subject('Laravel SMTP Test');
        });
        $this->info("✅ Email sent successfully! Check your inbox (and spam folder).");
    } catch (\Exception $e) {
        $this->error("❌ Failed to send email.");
        $this->error("Error Message: " . $e->getMessage());
        $this->line("\nFull Stack Trace (first 500 chars):");
        $this->line(substr($e->getTraceAsString(), 0, 500));
    }
})->purpose('Test mail configuration and connection');
