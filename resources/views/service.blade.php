@extends('layouts.app')

@section('header')
    @include('partials.page-header', ['heading' => 'Our Services'])
@endsection

@section('content')
    @include('partials.services')
@endsection
