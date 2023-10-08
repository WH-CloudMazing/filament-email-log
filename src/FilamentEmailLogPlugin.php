<?php

namespace Cloudmazing\FilamentEmailLog;

use Cloudmazing\FilamentEmailLog\Filament\Resources\EmailResource;
use Cloudmazing\FilamentEmailLog\Filament\Resources\EmailResource\Pages\ListEmails;
use Cloudmazing\FilamentEmailLog\Filament\Resources\EmailResource\Pages\ViewEmail;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentEmailLogPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-email-log';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                EmailResource::class,
            ])
            ->pages([
                ListEmails::class,
                ViewEmail::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
