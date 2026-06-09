<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contracts\ContactServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ContactMessageController extends Controller
{
    public function __construct(
        private readonly ContactServiceInterface $contacts,
    ) {
    }

    public function index()
    {
        return view('admin.messages.index');
    }

    /** AJAX source for Yajra DataTables. */
    public function data(Request $request): JsonResponse
    {
        $query = $this->contacts->query()->select('contact_messages.*');

        return DataTables::eloquent($query)
            ->editColumn('is_read', fn ($m) => $m->is_read
                ? '<span class="badge badge-secondary">Read</span>'
                : '<span class="badge badge-warning">New</span>')
            ->editColumn('message', fn ($m) => e(Str::limit($m->message, 50)))
            ->editColumn('created_at', fn ($m) => $m->created_at->format('d M Y, H:i'))
            ->addColumn('actions', function ($m) {
                $view = '<a href="' . route('admin.messages.show', $m) . '" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a> ';
                $del = '<form action="' . route('admin.messages.destroy', $m) . '" method="POST" class="d-inline js-delete">'
                    . csrf_field() . method_field('DELETE')
                    . '<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></form>';

                return $view . $del;
            })
            ->rawColumns(['is_read', 'actions'])
            ->make(true);
    }

    public function show(int $id)
    {
        $message = $this->contacts->find($id);
        $this->contacts->markAsRead($message);

        return view('admin.messages.show', ['message' => $message]);
    }

    public function destroy(int $id)
    {
        $this->contacts->delete($this->contacts->find($id));

        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}
