<?php

namespace App\Providers\Filament;

use App\Http\Middleware\SetLocale;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Css;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Support\HtmlString;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * AdminPanelProvider
 * ----------------------------------------------------------------------
 * TrustFlow CRM — Filament Admin Panel configuration.
 *
 * Design language: "TrustFlow Indigo"
 *   primary:  Indigo   (trust, professionalism)
 *   gray:     Slate    (modern neutral canvas)
 *   success:  Emerald  (won deals, paid invoices)
 *   warning:  Amber    (at-risk, overdue)
 *   danger:   Rose     (lost, failed)
 *   info:     Sky      (informational callouts)
 *
 * Inspired by Linear / Attio / Notion — soft shadows, tight vertical
 * rhythm, sidebar-collapsible groups, global search.
 */
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->brandName('TrustFlow CRM')
            ->defaultThemeMode(ThemeMode::System)
            ->darkMode(true)
            ->colors([
                'primary' => Color::Indigo,
                'gray'    => Color::Slate,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'danger'  => Color::Rose,
                'info'    => Color::Sky,
            ])
            ->font('Inter')
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('full')
            ->globalSearch()
            ->breadcrumbs(true)
            ->databaseNotifications()
            ->databaseNotificationsPolling('60s')
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                fn (): HtmlString => new HtmlString(
                    '<link rel="stylesheet" href="'.asset('css/trustflow-theme.css').'">'
                ),
            )
            ->navigationGroups([
                NavigationGroup::make()->label(fn () => __('filament.sales'))->icon('heroicon-o-megaphone')->collapsible(false),
                NavigationGroup::make()->label(fn () => __('filament.delivery'))->icon('heroicon-o-cube')->collapsible(true),
                NavigationGroup::make()->label(fn () => __('filament.finance'))->icon('heroicon-o-banknotes')->collapsible(true),
                NavigationGroup::make()->label(fn () => __('filament.analytics'))->icon('heroicon-o-chart-bar-square')->collapsible(true),
                NavigationGroup::make()->label(fn () => __('filament.system'))->icon('heroicon-o-cog-6-tooth')->collapsible(true),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\CustomDashboard::class,
                \App\Filament\Pages\LocaleSwitcher::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\TrustFlowKpiWidget::class,
                \App\Filament\Widgets\SalesFunnelWidget::class,
                \App\Filament\Widgets\ProfitChartWidget::class,
                \App\Filament\Widgets\AIInsightsWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                SetLocale::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->login();
    }
}
