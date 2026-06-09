<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Services\Contracts\ContactServiceInterface;

class DashboardController extends Controller
{
    public function __construct(
        private readonly ContactServiceInterface $contacts,
    ) {
    }

    public function index()
    {
        return view('admin.dashboard', [
            'serviceCount'  => Service::count(),
            'projectCount'  => Project::count(),
            'messageCount'  => $this->contacts->query()->count(),
            'unreadCount'   => $this->contacts->unreadCount(),
        ]);
    }
}
