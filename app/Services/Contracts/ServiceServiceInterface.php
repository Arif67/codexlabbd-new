<?php

namespace App\Services\Contracts;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

interface ServiceServiceInterface
{
    /** Active services for the public site, ordered. */
    public function publicList(): Collection;

    /** Query builder for DataTables (admin). */
    public function query(): Builder;

    public function find(int $id): Service;

    public function create(array $data): Service;

    public function update(Service $service, array $data): Service;

    public function delete(Service $service): void;
}
