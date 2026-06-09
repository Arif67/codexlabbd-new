<?php

namespace App\Services;

use App\Models\SiteSetting;
use App\Services\Contracts\SettingServiceInterface;
use Illuminate\Support\Facades\Cache;

class SettingService implements SettingServiceInterface
{
    private const CACHE_KEY = 'site_settings';

    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return SiteSetting::query()->pluck('value', 'key')->toArray();
        });
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->all()[$key] ?? $default;
    }

    public function updateMany(array $data): void
    {
        foreach ($data as $key => $value) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Cache::forget(self::CACHE_KEY);
    }
}
