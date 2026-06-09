<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contracts\SettingServiceInterface;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        private readonly SettingServiceInterface $settings,
    ) {
    }

    public function edit()
    {
        return view('admin.settings.edit', [
            'settings' => $this->settings->all(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'tagline'          => ['nullable', 'string', 'max:255'],
            'address'          => ['nullable', 'string', 'max:255'],
            'phone'            => ['nullable', 'string', 'max:100'],
            'email'            => ['nullable', 'email', 'max:255'],
            'social_facebook'  => ['nullable', 'url', 'max:255'],
            'social_twitter'   => ['nullable', 'url', 'max:255'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_linkedin'  => ['nullable', 'url', 'max:255'],
            'social_youtube'   => ['nullable', 'url', 'max:255'],
        ]);

        $this->settings->updateMany($data);

        return redirect()->route('admin.settings.edit')->with('success', 'Settings saved.');
    }
}
