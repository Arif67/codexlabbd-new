@extends('adminlte::page')

@section('title', $service->exists ? 'Edit Service' : 'Add Service')

@section('content_header')
    <h1 class="m-0">{{ $service->exists ? 'Edit Service' : 'Add Service' }}</h1>
@stop

@section('content')
    @include('admin.partials.alerts')

    @php
        // Rebuild the builder from saved JSON. For legacy services that only
        // have a plain description (no builder model yet), seed one text block.
        $initialJson = old('content_json', $service->content_json);
        if (blank($initialJson) && filled($service->description)) {
            $initialJson = json_encode([[
                'type' => 'text',
                'html' => e($service->description),
            ]]);
        }
    @endphp

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
                    <label>Short Excerpt <small class="text-muted">(card e dekhabe)</small></label>
                    <input type="text" name="excerpt" class="form-control" maxlength="500"
                           value="{{ old('excerpt', $service->excerpt) }}"
                           placeholder="Service card er jonno ek line summary">
                    <small class="text-muted">Khali rakhle content theke auto-excerpt toiri hobe.</small>
                </div>

                <div class="form-group">
                    <label>Content Builder <small class="text-muted">(text, image, video, row/column)</small></label>
                    <div id="content-builder" class="cb-wrap"
                         data-upload-url="{{ route('admin.builder.upload') }}"
                         data-csrf="{{ csrf_token() }}"
                         data-initial="{{ $initialJson }}">
                        <div class="cb-toolbar">
                            <button type="button" class="cb-add" data-add="heading"><i class="fas fa-heading"></i> Heading</button>
                            <button type="button" class="cb-add" data-add="text"><i class="fas fa-paragraph"></i> Text</button>
                            <button type="button" class="cb-add" data-add="image"><i class="fas fa-image"></i> Image</button>
                            <button type="button" class="cb-add" data-add="video"><i class="fas fa-video"></i> Video</button>
                            <span class="cb-sep"></span>
                            <button type="button" class="cb-add" data-add="row1"><i class="fas fa-square"></i> 1 Col</button>
                            <button type="button" class="cb-add" data-add="row2"><i class="fas fa-columns"></i> 2 Cols</button>
                            <button type="button" class="cb-add" data-add="row3"><i class="fas fa-th"></i> 3 Cols</button>
                        </div>
                        <div class="cb-canvas"></div>
                    </div>
                    {{-- Builder fills these on submit --}}
                    <input type="hidden" name="content_json" value="{{ old('content_json', $service->content_json) }}">
                    <textarea name="description" class="d-none">{{ old('description', $service->description) }}</textarea>
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

@section('css')
    <link rel="stylesheet" href="{{ asset('css/builder.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/builder.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            BoostBuilder.init('#content-builder');
        });
    </script>
@stop
