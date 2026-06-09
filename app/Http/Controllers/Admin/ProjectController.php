<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use App\Services\Contracts\ProjectServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectServiceInterface $projects,
    ) {
    }

    public function index()
    {
        return view('admin.projects.index');
    }

    /** AJAX source for Yajra DataTables. */
    public function data(Request $request): JsonResponse
    {
        $query = $this->projects->query()->select('projects.*');

        return DataTables::eloquent($query)
            ->addColumn('thumb', fn ($p) => '<img src="' . e($p->image_url) . '" style="width:60px;height:40px;object-fit:cover;border-radius:4px;">')
            ->editColumn('is_active', fn ($p) => $p->is_active
                ? '<span class="badge badge-success">Active</span>'
                : '<span class="badge badge-secondary">Hidden</span>')
            ->addColumn('actions', function ($p) {
                $edit = '<a href="' . route('admin.projects.edit', $p) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> ';
                $del = '<form action="' . route('admin.projects.destroy', $p) . '" method="POST" class="d-inline js-delete">'
                    . csrf_field() . method_field('DELETE')
                    . '<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></form>';

                return $edit . $del;
            })
            ->rawColumns(['thumb', 'is_active', 'actions'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.projects.form', ['project' => new Project()]);
    }

    public function store(ProjectRequest $request)
    {
        $this->projects->create($request->validated());

        return redirect()->route('admin.projects.index')->with('success', 'Project created.');
    }

    public function edit(int $id)
    {
        return view('admin.projects.form', ['project' => $this->projects->find($id)]);
    }

    public function update(ProjectRequest $request, int $id)
    {
        $this->projects->update($this->projects->find($id), $request->validated());

        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(int $id)
    {
        $this->projects->delete($this->projects->find($id));

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }
}
