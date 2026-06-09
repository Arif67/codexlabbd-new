@extends('adminlte::page')

@section('title', 'Messages')

@section('plugins.Datatables', true)

@section('content_header')
    <h1 class="m-0">Contact Messages</h1>
@stop

@section('content')
    @include('admin.partials.alerts')

    <div class="card">
        <div class="card-body">
            <table id="messages-table" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Received</th>
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
            $('#messages-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.messages.data') }}',
                order: [[0, 'desc']],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'is_read', name: 'is_read' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'subject', name: 'subject' },
                    { data: 'message', name: 'message' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ],
            });

            $(document).on('submit', '.js-delete', function (e) {
                if (!confirm('Delete this message?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@stop
