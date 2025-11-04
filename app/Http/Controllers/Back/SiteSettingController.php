<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::first();
        if (! $settings) {
            $settings = SiteSetting::create([]);
        }

        return view('back.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = SiteSetting::firstOrNew(['id' => 1]);

        $data = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'favicon' => 'nullable|mimes:jpg,jpeg,png,webp,svg,ico|max:1024',
            'social_links' => 'nullable|array',
            'social_links.facebook' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
            'social_links.youtube' => 'nullable|url',
            'social_links.linkedin' => 'nullable|url',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'maintenance_mode' => 'nullable|boolean',
            'analytics_code' => 'nullable|string',
            'primary_color' => 'nullable|string|max:20',
            'contact_hours' => 'nullable|string',
            'support_whatsapp' => 'nullable|string|max:60',
            'enable_registration' => 'nullable|boolean',
        ]);

        // handle logo upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = $file->store('site', 'public');
            // delete old logo
            if ($settings->logo && Storage::disk('public')->exists($settings->logo)) {
                Storage::disk('public')->delete($settings->logo);
            }
            $data['logo'] = $path;
        }

        // handle favicon upload
        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $path = $file->store('site', 'public');
            // delete old favicon
            if ($settings->favicon && Storage::disk('public')->exists($settings->favicon)) {
                Storage::disk('public')->delete($settings->favicon);
            }
            $data['favicon'] = $path;
        }

        // cast social_links to array if provided (individual inputs named social_links[platform])
        if ($request->has('social_links')) {
            $links = array_filter($request->input('social_links', []), function ($v) {
                return $v !== null && $v !== '';
            });
            $data['social_links'] = $links;
        }

        // Ensure maintenance_mode boolean when checkbox not sent
        if (! isset($data['maintenance_mode'])) {
            $data['maintenance_mode'] = false;
        }

        // ensure enable_registration boolean default true
        if (! isset($data['enable_registration'])) {
            $data['enable_registration'] = true;
        }

        $settings->fill($data);
        $settings->save();

        return redirect()->back()->with('success', 'Site settings updated.');
    }
}
