<?php

namespace Cloudmazing\FilamentEmailLog\Filament\Resources;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Config;
use Cloudmazing\FilamentEmailLog\Filament\Resources\EmailResource\Pages\ListEmails;
use Cloudmazing\FilamentEmailLog\Filament\Resources\EmailResource\Pages\ViewEmail;
use Cloudmazing\FilamentEmailLog\Models\Email;

class EmailResource extends Resource
{
    protected static ?string $model = Email::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function getModelLabel(): string
    {
        return __('filament-email-log::filament.resources.email');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-email-log::filament.resources.emails');
    }

    public static function getNavigationLabel(): string
    {
        return static::getPluralModelLabel();
    }

    public static function getNavigationGroup(): ?string
    {
        return Config::get('filament-email-log.resource.group') ?? parent::getNavigationGroup();
    }

    public static function getNavigationSort(): ?int
    {
        return Config::get('filament-email-log.resource.sort') ?? parent::getNavigationSort();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Envelope')->schema([
                    TextInput::make('created_at')
                        ->label(__('filament-email-log::filament.fields.created_at')),
                    TextInput::make('from')
                        ->label(__('filament-email-log::filament.fields.from')),
                    TextInput::make('to')
                        ->label(__('filament-email-log::filament.fields.to')),
                    TextInput::make('cc')
                        ->label(__('filament-email-log::filament.fields.cc')),
                    TextInput::make('subject')->columnSpan(2)
                        ->label(__('filament-email-log::filament.fields.subject')),
                ])->columns(3),
                Tabs::make('Content')
                    ->label(__('filament-email-log::filament.fields.content'))
                    ->tabs([
                        Tab::make('HTML')
                            ->label(__('filament-email-log::filament.fields.html'))
                            ->schema([
                                ViewField::make('html_body')->hiddenLabel()
                                    ->label(__('filament-email-log::filament.fields.html_body'))
                                    ->view('filament-email-log::HtmlEmailView'),
                            ]),
                        Tab::make('Text')
                            ->label(__('filament-email-log::filament.fields.text'))
                            ->schema([
                                Textarea::make('text_body')->hiddenLabel()
                                    ->label(__('filament-email-log::filament.fields.text_body')),
                            ]),
                        Tab::make('Raw')
                            ->label(__('filament-email-log::filament.fields.raw'))
                            ->schema([
                                Textarea::make('raw_body')
                                    ->label(__('filament-email-log::filament.fields.raw_body'))
                                    ->extraAttributes(['class' => 'font-mono text-xs'])
                                    ->hiddenLabel(),
                            ]),
                        Tab::make('Debug information')
                            ->label(__('filament-email-log::filament.fields.debug_information'))
                            ->schema([
                                Textarea::make('sent_debug_info')
                                    ->label(__('filament-email-log::filament.fields.sent_debug_info'))
                                    ->extraAttributes(['class' => 'font-mono text-xs'])
                                    ->hiddenLabel(),
                            ]),
                    ])->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('filament-email-log::filament.fields.created_at'))
                    ->sortable(),
                TextColumn::make('from')
                    ->label(__('filament-email-log::filament.fields.from'))
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('to')
                    ->label(__('filament-email-log::filament.fields.to'))
                    ->searchable(),
                TextColumn::make('cc')
                    ->label(__('filament-email-log::filament.fields.cc'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('subject')
                    ->label(__('filament-email-log::filament.fields.subject'))
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        return $state;
                    })
                    ->searchable(),
            ])
            ->bulkActions([])
            ->filters([
                //
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmails::route('/'),
            'view' => ViewEmail::route('/{record}'),
        ];
    }
}
