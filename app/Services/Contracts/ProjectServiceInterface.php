<?php

namespace App\Services\Contracts;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface ProjectServiceInterface
{
    /** Active projects for the public site, ordered. */
    public function publicList(): Collection;

    /** Query builder for DataTables (admin). */
    public function query(): Builder;

    public function find(int $id): Project;

    public function create(array $data): Project;

    public function update(Project $project, array $data): Project;

    public function delete(Project $project): void;
}
