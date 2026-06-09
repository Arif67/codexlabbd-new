<?php

namespace App\Services;

use App\Models\Project;
use App\Services\Contracts\ProjectServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProjectService implements ProjectServiceInterface
{
    public function publicList(): Collection
    {
        return Project::query()->active()->ordered()->get();
    }

    public function query(): Builder
    {
        return Project::query();
    }

    public function find(int $id): Project
    {
        return Project::query()->findOrFail($id);
    }

    public function create(array $data): Project
    {
        $data = $this->handleImage($data);

        return Project::create($data);
    }

    public function update(Project $project, array $data): Project
    {
        $data = $this->handleImage($data, $project);
        $project->update($data);

        return $project;
    }

    public function delete(Project $project): void
    {
        if ($project->image && Storage::disk('public')->exists($project->image)) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();
    }

    /**
     * Store an uploaded image (if present) and replace the old one.
     */
    private function handleImage(array $data, ?Project $project = null): array
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            if ($project && $project->image && Storage::disk('public')->exists($project->image)) {
                Storage::disk('public')->delete($project->image);
            }

            $data['image'] = $data['image']->store('projects', 'public');
        } else {
            unset($data['image']);
        }

        return $data;
    }
}
