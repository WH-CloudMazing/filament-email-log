<?php

namespace Cloudmazing\FilamentEmailLog;

use Filament\PluginServiceProvider;
use Cloudmazing\FilamentEmailLog\Filament\Resources\EmailResource;
use Cloudmazing\FilamentEmailLog\Providers\EmailMessageServiceProvider;
use Illuminate\Support\Facades\Config;
use Spatie\LaravelPackageTools\Package;

class FilamentEmailLogServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-email-log';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */

        parent::configurePackage($package);

        $package
            ->name('filament-email-log')
            ->hasConfigFile('filament-email-log')
            ->hasMigrations([
                'create_filament_email_log_table',
                'add_raw_and_debug_fields_to_filament_email_log_table',
                'add_mailer_column_to_filament_email_log_table',
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
