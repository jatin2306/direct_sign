<?php

use App\Models\Admin;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('admin:password {email : The admin email} {password? : The new password (optional; will prompt if omitted)}', function () {
    $admin = Admin::where('email', $this->argument('email'))->first();
    if (! $admin) {
        $this->error('No admin found with email: '.$this->argument('email'));
        $this->info('Existing admins: '.Admin::pluck('email')->join(', '));

        return 1;
    }
    $password = $this->argument('password') ?? $this->secret('New password');
    $admin->password = Hash::make($password);
    $admin->save();
    $this->info('Password updated for: '.$admin->email);

    return 0;
})->purpose('Change an admin user password');

