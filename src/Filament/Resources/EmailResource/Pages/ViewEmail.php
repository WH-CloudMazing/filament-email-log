<?php

namespace Cloudmazing\FilamentEmailLog\Filament\Resources\EmailResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Cloudmazing\FilamentEmailLog\Filament\Resources\EmailResource;
use Illuminate\Support\Facades\Config;

class ViewEmail extends ViewRecord
{
    public static function getResource(): string
    {
        return Config::get('filament-email-log.resource.class', EmailResource::class);
    }

    protected function getTitle(): string
    {
        return __('filament-email-log::filament.resources.email');
    }
}
