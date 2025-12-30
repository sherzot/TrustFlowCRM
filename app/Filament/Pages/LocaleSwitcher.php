<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LocaleSwitcher extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-language';

    protected static string $view = 'filament.pages.locale-switcher';

    protected static ?string $navigationLabel = '言語設定';

    protected static ?string $navigationGroup = '設定';

    protected static ?int $navigationSort = 99;

    public static function getNavigationLabel(): string
    {
        return __('filament.language_settings');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.settings');
    }

    public function switchLocale(string $locale): void
    {
        if (in_array($locale, ['ja', 'en', 'ru', 'uz'])) {
            Session::put('locale', $locale);
            App::setLocale($locale);
            
            $this->redirect(route('filament.admin.pages.locale-switcher'));
        }
    }
}

