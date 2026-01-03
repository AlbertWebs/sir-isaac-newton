<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\SchoolInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        // Only Super Admin can access settings
        if (!auth()->user()->isSuperAdmin()) {
            return view('errors.unauthorized', [
                'message' => 'Only Super Administrators can access system settings. Please contact your administrator if you need access to this page.'
            ]);
        }

        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        $schoolInfo = SchoolInformation::firstOrCreate([]); // Fetch or create school information
        
        return view('settings.index', compact('settings', 'schoolInfo'));
    }

    public function update(Request $request)
    {
        // Only Super Admin can update settings
        if (!auth()->user()->isSuperAdmin()) {
            return view('errors.unauthorized', [
                'message' => 'Only Super Administrators can update system settings. Please contact your administrator if you need access to this feature.'
            ]);
        }

        $validated = $request->validate([
            'settings' => ['required', 'array'],
            'settings.school_name' => ['nullable', 'string'],
            'settings.school_email' => ['nullable', 'email'],
            'settings.school_phone' => ['nullable', 'string'],
            'settings.school_address' => ['nullable', 'string'],
            'settings.school_website' => ['nullable', 'url'],
            'settings.currency' => ['nullable', 'string'],
            'settings.currency_symbol' => ['nullable', 'string'],
            'settings.meta_title' => ['nullable', 'string', 'max:255'],
            'settings.meta_description' => ['nullable', 'string', 'max:500'],
            'settings.meta_keywords' => ['nullable', 'string', 'max:255'],
            'settings.social_media.facebook' => ['nullable', 'url'],
            'settings.social_media.twitter' => ['nullable', 'url'],
            'settings.social_media.linkedin' => ['nullable', 'url'],
            'settings.social_media.instagram' => ['nullable', 'url'],
            'settings.social_media.whatsapp' => ['nullable', 'url'],
            'logo' => ['nullable', 'image', 'max:2048'], // 2MB max
            'receipt_logo' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        $schoolInfo = SchoolInformation::firstOrCreate([]);

        // Handle normal logo upload
        if ($request->hasFile('logo')) {
            if ($schoolInfo->logo) {
                Storage::disk('public')->delete($schoolInfo->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $schoolInfo->logo = $logoPath;
        }

        // Handle receipt logo upload
        if ($request->hasFile('receipt_logo')) {
            if ($schoolInfo->receipt_logo) {
                Storage::disk('public')->delete($schoolInfo->receipt_logo);
            }
            $receiptLogoPath = $request->file('receipt_logo')->store('logos', 'public');
            $schoolInfo->receipt_logo = $receiptLogoPath;
        }
        
        // Update School Information fields directly
        $schoolInfo->name = $validated['settings']['school_name'] ?? $schoolInfo->name;
        $schoolInfo->email = $validated['settings']['school_email'] ?? $schoolInfo->email;
        $schoolInfo->phone = $validated['settings']['school_phone'] ?? $schoolInfo->phone;
        $schoolInfo->address = $validated['settings']['school_address'] ?? $schoolInfo->address;
        $schoolInfo->website = $validated['settings']['school_website'] ?? $schoolInfo->website;
        $schoolInfo->meta_title = $validated['settings']['meta_title'] ?? $schoolInfo->meta_title;
        $schoolInfo->meta_description = $validated['settings']['meta_description'] ?? $schoolInfo->meta_description;
        $schoolInfo->meta_keywords = $validated['settings']['meta_keywords'] ?? $schoolInfo->meta_keywords;

        // Update social media links
        $existingSocialMedia = is_array($schoolInfo->social_media) ? $schoolInfo->social_media : [];
        $newSocialMedia = $validated['settings']['social_media'] ?? [];
        $schoolInfo->social_media = array_merge($existingSocialMedia, $newSocialMedia);

        $schoolInfo->save();

        // Update generic settings (currency, currency_symbol)
        foreach ($validated['settings'] as $key => $value) {
            if (in_array($key, ['currency', 'currency_symbol'])) {
                $setting = Setting::where('key', $key)->first();
                if ($setting) {
                    $setting->update(['value' => $value]);
                } else {
                    Setting::create(['key' => $key, 'value' => $value, 'group' => 'general']);
                }
            }
        }


        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }
}
