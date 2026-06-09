<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Services\Contracts\ServiceServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    public function __construct(
        private readonly ServiceServiceInterface $services,
    ) {
    }

    public function index()
    {
        return view('admin.services.index');
    }

    /** AJAX source for Yajra DataTables. */
    public function data(Request $request): JsonResponse
    {
        $query = $this->services->query()->select('services.*');

        return DataTables::eloquent($query)
            ->editColumn('icon', fn ($s) => '<i class="fa ' . e($s->icon) . ' fa-lg"></i> <code>' . e($s->icon) . '</code>')
            ->editColumn('is_active', fn ($s) => $s->is_active
                ? '<span class="badge badge-success">Active</span>'
                : '<span class="badge badge-secondary">Hidden</span>')
            ->editColumn('description', fn ($s) => \Illuminate\Support\Str::limit($s->description, 60))
            ->addColumn('actions', function ($s) {
                $edit = '<a href="' . route('admin.services.edit', $s) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> ';
                $del = '<form action="' . route('admin.services.destroy', $s) . '" method="POST" class="d-inline js-delete">'
                    . csrf_field() . method_field('DELETE')
                    . '<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></form>';

                return $edit . $del;
            })
            ->rawColumns(['icon', 'is_active', 'actions'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.services.form', ['service' => new \App\Models\Service()]);
    }

    public function store(ServiceRequest $request)
    {
        $this->services->create($request->validated());

        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    public function edit(int $id)
    {
        return view('admin.services.form', ['service' => $this->services->find($id)]);
    }

    public function update(ServiceRequest $request, int $id)
    {
        $this->services->update($this->services->find($id), $request->validated());

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy(int $id)
    {
        $this->services->delete($this->services->find($id));

        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }
}
