<?php

namespace App\Services\Contracts;

interface SettingServiceInterface
{
    /** All settings as a key => value array. */
    public function all(): array;

    public function get(string $key, mixed $default = null): mixed;

    /** Persist many key => value settings at once. */
    public function updateMany(array $data): void;
}
