@extends('adminlte::page')

@section('title', 'Projects')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Projects</h1>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Project
        </a>
    </div>
@stop

@section('content')
    @include('admin.partials.alerts')

    <div class="card">
        <div class="card-body">
            <table id="projects-table" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th width="90">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            $('#projects-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.projects.data') }}',
                order: [[4, 'asc']],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'thumb', name: 'thumb', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { data: 'category', name: 'category' },
                    { data: 'sort_order', name: 'sort_order' },
                    { data: 'is_active', name: 'is_active' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ],
            });

            $(document).on('submit', '.js-delete', function (e) {
                if (!confirm('Delete this item? This cannot be undone.')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@stop
