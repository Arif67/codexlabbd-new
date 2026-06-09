@extends('layouts.app')

@section('header')
    @include('partials.page-header', ['heading' => $service->title])
@endsection

@section('content')
    <div class="container-fluid py-5">
        <div class="container px-lg-5">
            <div class="row g-5">
                <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="d-flex align-items-center mb-4">
                        <div class="service-icon flex-shrink-0 me-3" style="width:64px;height:64px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa {{ $service->icon }} fa-2x text-primary"></i>
                        </div>
                        <h1 class="mb-0">{{ $service->title }}</h1>
                    </div>

                    <div class="service-content">
                        @if (filled($service->description))
                            {!! $service->description !!}
                        @else
                            <p>{{ $service->card_text }}</p>
                        @endif
                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary rounded-pill py-2 px-4 mt-3">Get a Quote</a>
                </div>

                <!-- Sidebar: other services -->
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="bg-light rounded p-4">
                        <h5 class="mb-3">Our Services</h5>
                        <div class="d-flex flex-column">
                            @foreach ($services as $other)
                                <a class="d-flex align-items-center text-body py-2 border-bottom {{ $other->id === $service->id ? 'fw-bold text-primary' : '' }}"
                                   href="{{ route('service.show', $other) }}">
                                    <i class="fa {{ $other->icon }} text-primary me-2"></i>{{ $other->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
