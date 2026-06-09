@extends('adminlte::page')

@section('title', 'Message')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Message #{{ $message->id }}</h1>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-default"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $message->subject }}</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">From</dt>
                <dd class="col-sm-9">{{ $message->name }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9"><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></dd>

                <dt class="col-sm-3">Received</dt>
                <dd class="col-sm-9">{{ $message->created_at->format('d M Y, H:i') }}</dd>

                <dt class="col-sm-3">Message</dt>
                <dd class="col-sm-9" style="white-space:pre-line;">{{ $message->message }}</dd>
            </dl>
        </div>
        <div class="card-footer">
            <a href="mailto:{{ $message->email }}?subject=RE: {{ $message->subject }}" class="btn btn-primary">
                <i class="fas fa-reply"></i> Reply by Email
            </a>
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline js-delete">
                @csrf @method('DELETE')
                <button class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).on('submit', '.js-delete', function (e) {
            if (!confirm('Delete this message?')) { e.preventDefault(); }
        });
    </script>
@stop
