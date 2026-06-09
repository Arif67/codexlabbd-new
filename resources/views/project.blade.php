@extends('layouts.app')

@section('header')
    @include('partials.page-header', ['heading' => 'Our Projects'])
@endsection

@section('content')
    @include('partials.projects')
@endsection
