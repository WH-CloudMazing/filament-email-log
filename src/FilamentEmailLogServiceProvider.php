<?php

namespace Cloudmazing\FilamentEmailLog;

use Cloudmazing\FilamentEmailLog\Filament\Resources\EmailResource;
use Cloudmazing\FilamentEmailLog\Providers\EmailMessageServiceProvider;
use Illuminate\Support\Facades\Config;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentEmailLogServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-email-log';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile('filament-email-log')
            ->hasTranslations()
            ->hasMigrations([
                'create_filament_email_log_table',
                'add_raw_and_debug_fields_to_filament_email_log_table',
                'add_mailer_column_to_filament_email_log_table',
                'add_mailable_columns_to_filament_email_log_table',
            ]);

        $this->app->register(EmailMessageServiceProvider::class);
    }

    protected function getResources(): array
    {
        return [
            Config::get('filament-email-log.resource.class', EmailResource::class)
        ];
    }
}
