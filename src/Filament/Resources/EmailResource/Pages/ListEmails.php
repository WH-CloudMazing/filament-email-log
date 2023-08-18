<?php

namespace Cloudmazing\FilamentEmailLog\Filament\Resources\EmailResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Cloudmazing\FilamentEmailLog\Filament\Resources\EmailResource;
use Illuminate\Support\Facades\Config;

class ListEmails extends ListRecords
{
    public static function getResource(): string
    {
        return Config::get('filament-email-log.resource.class', EmailResource::class);
    }

    protected function getTitle(): string
    {
        return EmailResource::getPluralModelLabel();
    }
}
