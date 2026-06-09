@extends('layouts.app')

@section('header')
    @include('partials.page-header', ['heading' => 'Contact Us'])
@endsection

@section('content')
    <!-- Contact Start -->
    <div class="container-fluid py-5">
        <div class="container px-lg-5">
            <div class="row g-5 mb-5">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px;">
                            <i class="fa fa-map-marker-alt text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-1">Address</h6>
                            <span>{{ config('site.address') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px;">
                            <i class="fa fa-phone-alt text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-1">Call Us</h6>
                            <span>{{ config('site.phone') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px;">
                            <i class="fa fa-envelope text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-1">Email Us</h6>
                            <span>{{ config('site.email') }}</span>
                        </div>
                    </div>
                </div>
            </div>
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
    <!-- Contact End -->
@endsection
