@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $serviceCount }}</h3>
                    <p>Services</p>
                </div>
                <div class="icon"><i class="fas fa-concierge-bell"></i></div>
                <a href="{{ route('admin.services.index') }}" class="small-box-footer">
                    Manage <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $projectCount }}</h3>
                    <p>Projects</p>
                </div>
                <div class="icon"><i class="fas fa-briefcase"></i></div>
                <a href="{{ route('admin.projects.index') }}" class="small-box-footer">
                    Manage <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $messageCount }}</h3>
                    <p>Total Messages</p>
                </div>
                <div class="icon"><i class="fas fa-envelope"></i></div>
                <a href="{{ route('admin.messages.index') }}" class="small-box-footer">
                    View <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $unreadCount }}</h3>
                    <p>Unread Messages</p>
                </div>
                <div class="icon"><i class="fas fa-bell"></i></div>
                <a href="{{ route('admin.messages.index') }}" class="small-box-footer">
                    Read now <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5><i class="fas fa-info-circle text-info"></i> Welcome, {{ auth()->user()->name }}</h5>
            <p class="text-muted mb-0">
                Manage your website content from the sidebar — Services, Projects, contact Messages and Site Settings.
                Changes appear instantly on the public website.
            </p>
        </div>
    </div>
@stop
