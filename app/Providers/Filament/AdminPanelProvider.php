<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Tenancy\EditTeamProfile;
use App\Filament\Widgets\AdminStatsOverview;
use App\Filament\Widgets\CategoryChart;
use App\Filament\Widgets\ListofPost;
use App\Filament\Widgets\PostsChart;
use App\Models\Team;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
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
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use RegisterTeam;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            // ->emailVerification()
            // ->passwordReset()
            //->profile(EditProfile::class)
            ->profile(isSimple: true)
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])->font('Roboto Slab')
            ->favicon(asset('images\doodle\icons8-logo-48.png'))
            // ->brandLogo(asset('images\doodle\icons8-logo-48.png'))->brandLogoHeight('50px')
            // ->brandName('k-internship-Daily-Accomplishment-Report-sys')
            ->brandName('K-DARS')
            // ->brandUrl('https://greenbird.com') => this will redirect to the website
            // ->darkmode(true)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                // Pages\Dashboard::class,
                // Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
                AdminStatsOverview::class,
                CategoryChart::class,
                ListofPost::class,
                PostsChart::class,
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
            ]);
    }

    public function panels(Panel $panel): Panel
    {
        return $panel
            // ...
            // ->tenantProfile(RegistryTeam::class)
            // ->tenant(Team::class, ownershipRelationship: 'team')
            ->defaultThemeMode(ThemeMode::Light);
        // ->tenantRegistration(RegisterTeam::class)
        // ->tenantProfile(EditTeamProfile::class);
    }
}
