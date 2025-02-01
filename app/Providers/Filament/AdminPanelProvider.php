<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
<<<<<<< HEAD
use Filament\Http\Middleware\AuthenticateSession;
=======
>>>>>>> 8946dc6df92e05df38f1730fd54eb6665ede2343
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
<<<<<<< HEAD
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
=======
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Coolsam\Modules\ModulesPlugin;

// use UnexpectedJourney\FilamentResourcePicker\FilamentResourcePickerPlugin;
>>>>>>> 8946dc6df92e05df38f1730fd54eb6665ede2343

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
<<<<<<< HEAD
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
=======
            ->sidebarWidth('16rem')
            ->sidebarFullyCollapsibleOnDesktop()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([ Pages\Dashboard::class, ])
>>>>>>> 8946dc6df92e05df38f1730fd54eb6665ede2343
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
<<<<<<< HEAD
            ]);
    }
}
=======
            ])
            ->plugins([ModulesPlugin::make(),])
            // ->plugins([ModulesPlugin::make(), FilamentResourcePickerPlugin::make(),])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ;
            print('panel Hello World'); exit;
    }
}

>>>>>>> 8946dc6df92e05df38f1730fd54eb6665ede2343
