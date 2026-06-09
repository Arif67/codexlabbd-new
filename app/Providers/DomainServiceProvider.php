<?php

namespace App\Providers;

use App\Services\Contracts\ContactServiceInterface;
use App\Services\Contracts\ProjectServiceInterface;
use App\Services\Contracts\ServiceServiceInterface;
use App\Services\Contracts\SettingServiceInterface;
use App\Services\ContactService;
use App\Services\ProjectService;
use App\Services\ServiceService;
use App\Services\SettingService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Throwable;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Bind domain service interfaces to their implementations (DI).
     */
    public array $bindings = [
        ServiceServiceInterface::class => ServiceService::class,
        ProjectServiceInterface::class => ProjectService::class,
        ContactServiceInterface::class => ContactService::class,
        SettingServiceInterface::class => SettingService::class,
    ];

    /**
     * Hydrate the runtime site config from DB settings so the public
     * navbar/footer/partials keep working without per-view changes.
     */
    public function boot(SettingServiceInterface $settings): void
    {
        try {
            if (! Schema::hasTable('site_settings')) {
                return;
            }
        } catch (Throwable) {
            return; // DB not ready (e.g. during first migration)
        }

        $stored = $settings->all();

        if (empty($stored)) {
            return;
        }

        $social = [];
        foreach (['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'] as $network) {
            if (isset($stored["social_{$network}"])) {
                $social[$network] = $stored["social_{$network}"];
            }
        }

        config([
            'site.name'    => $stored['name']    ?? config('site.name'),
            'site.tagline' => $stored['tagline'] ?? config('site.tagline'),
            'site.address' => $stored['address'] ?? config('site.address'),
            'site.phone'   => $stored['phone']   ?? config('site.phone'),
            'site.email'   => $stored['email']   ?? config('site.email'),
            'site.social'  => $social ?: config('site.social'),
        ]);
    }
}
