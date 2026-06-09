@extends('layouts.app')

@section('header')
    @include('partials.page-header', ['heading' => 'About Us'])
@endsection

@section('content')
    @include('partials.about')
@endsection
