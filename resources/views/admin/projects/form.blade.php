@extends('adminlte::page')

@section('title', $project->exists ? 'Edit Project' : 'Add Project')

@section('content_header')
    <h1 class="m-0">{{ $project->exists ? 'Edit Project' : 'Add Project' }}</h1>
@stop

@section('content')
    @include('admin.partials.alerts')

    <div class="card">
        <form action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if ($project->exists)
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="form-group">
                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title', $project->title) }}" required>
                </div>

                <div class="form-group">
                    <label>Category <span class="text-danger">*</span></label>
                    <input type="text" name="category" class="form-control"
                           value="{{ old('category', $project->category) }}" required>
                    <small class="text-muted">e.g. SEO, Web Design, PPC, Branding</small>
                </div>

                <div class="form-group">
                    <label>Image</label>
                    @if ($project->exists && $project->image)
                        <div class="mb-2">
                            <img src="{{ $project->image_url }}" style="max-width:160px;border-radius:6px;">
                        </div>
                    @endif
                    <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input" id="image" accept="image/*">
                        <label class="custom-file-label" for="image">Choose image…</label>
                    </div>
                    <small class="text-muted">JPG/PNG/WEBP, max 4MB. {{ $project->exists ? 'Leave empty to keep current image.' : '' }}</small>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" min="0"
                               value="{{ old('sort_order', $project->sort_order ?? 0) }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="d-block">Status</label>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="is_active"
                                   {{ old('is_active', $project->exists ? $project->is_active : true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Active (visible on site)</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            $('.custom-file-input').on('change', function () {
                $(this).next('.custom-file-label').text(this.files[0]?.name ?? 'Choose image…');
            });
        });
    </script>
@stop
