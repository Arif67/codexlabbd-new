<?php

namespace App\Services;

use App\Models\Service;
use App\Services\Contracts\ServiceServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ServiceService implements ServiceServiceInterface
{
    public function publicList(): Collection
    {
        return Service::query()->active()->ordered()->get();
    }

    public function query(): Builder
    {
        return Service::query();
    }

    public function find(int $id): Service
    {
        return Service::query()->findOrFail($id);
    }

    public function create(array $data): Service
    {
        return Service::create($data);
    }

    public function update(Service $service, array $data): Service
    {
        $service->update($data);

        return $service;
    }

    public function delete(Service $service): void
    {
        $service->delete();
    }
}
