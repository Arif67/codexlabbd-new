@extends('layouts.app')

@section('header')
    <div class="container-fluid py-5 bg-primary hero-header mb-5">
        <div class="container my-5 py-5 px-lg-5">
            <div class="row g-5 py-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="text-white mb-4 animated zoomIn">Custom software solutions that move your business forward</h1>
                    <p class="text-white pb-3 animated zoomIn">{{ config('site.name') }} builds tailored web, mobile and enterprise software — and powers your growth with result-driven digital marketing. One team for both your product and your reach.</p>
                    <a href="{{ route('service') }}" class="btn btn-light py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Our Services</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light py-sm-3 px-sm-5 rounded-pill animated slideInRight">Get a Quote</a>
                </div>
                <div class="col-lg-6 text-center text-lg-start">
                    <img class="img-fluid" src="{{ asset('img/hero.png') }}" alt="{{ config('site.name') }}">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('partials.about')
    @include('partials.services')
    @include('partials.projects')

    <!-- Contact CTA Start -->
    <div class="container-fluid py-5">
        <div class="container px-lg-5">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                        <h6 class="position-relative d-inline text-primary ps-4">Contact Us</h6>
                        <h2 class="mt-2">Contact For Any Query</h2>
                    </div>
                    @include('partials.contact-form')
                </div>
            </div>
        </div>
    </div>
    <!-- Contact CTA End -->
@endsection
