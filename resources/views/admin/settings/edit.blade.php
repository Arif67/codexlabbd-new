@extends('adminlte::page')

@section('title', 'Site Settings')

@section('content_header')
    <h1 class="m-0">Site Settings</h1>
@stop

@section('content')
    @include('admin.partials.alerts')

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">General</h3></div>
                    <div class="card-body">
                        @php
                            $fields = [
                                'name' => 'Site Name',
                                'tagline' => 'Tagline',
                                'address' => 'Address',
                                'phone' => 'Phone',
                                'email' => 'Email',
                            ];
                        @endphp
                        @foreach ($fields as $key => $label)
                            <div class="form-group">
                                <label>{{ $label }} @if($key === 'name')<span class="text-danger">*</span>@endif</label>
                                <input type="{{ $key === 'email' ? 'email' : 'text' }}" name="{{ $key }}"
                                       class="form-control" value="{{ old($key, $settings[$key] ?? '') }}"
                                       {{ $key === 'name' ? 'required' : '' }}>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Social Links</h3></div>
                    <div class="card-body">
                        @php
                            $socials = [
                                'social_facebook' => ['Facebook', 'fab fa-facebook'],
                                'social_twitter' => ['Twitter / X', 'fab fa-twitter'],
                                'social_instagram' => ['Instagram', 'fab fa-instagram'],
                                'social_linkedin' => ['LinkedIn', 'fab fa-linkedin'],
                                'social_youtube' => ['YouTube', 'fab fa-youtube'],
                            ];
                        @endphp
                        @foreach ($socials as $key => [$label, $icon])
                            <div class="form-group">
                                <label>{{ $label }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="{{ $icon }}"></i></span>
                                    </div>
                                    <input type="url" name="{{ $key }}" class="form-control"
                                           placeholder="https://…" value="{{ old($key, $settings[$key] ?? '') }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Settings</button>
            </div>
        </div>
    </form>
@stop
