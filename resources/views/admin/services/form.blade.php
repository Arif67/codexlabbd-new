@extends('adminlte::page')

@section('title', $service->exists ? 'Edit Service' : 'Add Service')

@section('content_header')
    <h1 class="m-0">{{ $service->exists ? 'Edit Service' : 'Add Service' }}</h1>
@stop

@section('content')
    @include('admin.partials.alerts')

    <div class="card">
        <form action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}" method="POST">
            @csrf
            @if ($service->exists)
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="form-group">
                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title', $service->title) }}" required>
                </div>

                <div class="form-group">
                    <label>Font Awesome Icon class <span class="text-danger">*</span></label>
                    <input type="text" name="icon" class="form-control"
                           value="{{ old('icon', $service->icon ?: 'fa-star') }}" required>
                    <small class="text-muted">e.g. <code>fa-chart-line</code>, <code>fa-share-alt</code>. <a href="https://fontawesome.com/v5/search" target="_blank">Browse icons</a></small>
                </div>

                <div class="form-group">
                    <label>Description <span class="text-danger">*</span></label>
                    <textarea name="description" rows="4" class="form-control" required>{{ old('description', $service->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" min="0"
                               value="{{ old('sort_order', $service->sort_order ?? 0) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="d-block">Status</label>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="is_active"
                                   {{ old('is_active', $service->exists ? $service->is_active : true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Active (visible on site)</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@stop
