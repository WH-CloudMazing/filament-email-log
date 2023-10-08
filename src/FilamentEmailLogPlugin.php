<?php

namespace Cloudmazing\FilamentEmailLog;

use Cloudmazing\FilamentEmailLog\Filament\Resources\EmailResource;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Support\Facades\Config;

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
                Config::get('filament-email-log.resource.class', EmailResource::class),
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
