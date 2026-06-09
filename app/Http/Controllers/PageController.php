<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Services\Contracts\ContactServiceInterface;
use App\Services\Contracts\ProjectServiceInterface;
use App\Services\Contracts\ServiceServiceInterface;

class PageController extends Controller
{
    public function __construct(
        private readonly ServiceServiceInterface $services,
        private readonly ProjectServiceInterface $projects,
        private readonly ContactServiceInterface $contacts,
    ) {
    }

    public function home()
    {
        return view('home', [
            'services' => $this->services->publicList(),
            'projects' => $this->projects->publicList(),
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function service()
    {
        return view('service', [
            'services' => $this->services->publicList(),
        ]);
    }

    public function serviceShow(int $service)
    {
        $item = $this->services->find($service);

        abort_unless($item->is_active, 404);

        return view('service-detail', [
            'service' => $item,
            'services' => $this->services->publicList(),
        ]);
    }

    public function project()
    {
        return view('project', [
            'projects' => $this->projects->publicList(),
        ]);
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendContact(ContactRequest $request)
    {
        $this->contacts->store($request->validated());

        return redirect()
            ->back()
            ->with('success', 'Thank you! Your message has been sent. We will get back to you soon.');
    }
}
