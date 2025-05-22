<?php

use App\Console\Commands\NewProductsNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

(new Illuminate\Console\Scheduling\Schedule)->command(NewProductsNotification::class)
    ->everyTenMinutes()
    ->withoutOverlapping();
