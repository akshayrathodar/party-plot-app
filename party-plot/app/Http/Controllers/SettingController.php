<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('settings.index', compact('settings'));
    }

    /**
     * Update site settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update company name
        $this->updateSetting('company_name', $request->company_name);

        // Handle company logo upload
        if ($request->hasFile('company_logo')) {
            $oldLogo = $this->getSetting('company_logo');
            $logoName = uploadFile(
                $request->file('company_logo'),
                'company_logo',
                'settings',
                'admin',
                $oldLogo
            );
            $this->updateSetting('company_logo', $logoName);
        }

        return toastSuccess('Site settings updated successfully!');
    }

    /**
     * Update theme settings
     */
    public function themeUpdate(Request $request)
    {
        try {
            // Update theme settings
            $this->updateSetting('layout_type', $request->input('layout_type', 'ltr'));
            $this->updateSetting(
                'sidebar_type',
                $request->input('sidebar_type', 'compact-sidebar')
            );
            $this->updateSetting('sidebar_icon', $request->input('sidebar_icon', 'stroke-svg'));
            $this->updateSetting('theme_color', $request->input('theme_color', 'color-1'));
            $this->updateSetting('dark_mode', $request->input('dark_mode', 'light'));
            $this->updateSetting('primary_color', $request->input('primary_color', '#2B5F60'));
            $this->updateSetting('secondary_color', $request->input('secondary_color', '#C06240'));

            // Check if it's an AJAX request
            if (
                $request->ajax() ||
                $request->wantsJson() ||
                $request->header('X-Requested-With') === 'XMLHttpRequest'
            ) {
                return response()->json([
                    'success' => true,
                    'message' => 'Theme settings updated successfully',
                    'theme_updated' => true,
                ]);
            }

            return toastSuccess('Theme settings updated successfully!');
        } catch (\Exception $e) {
            if (
                $request->ajax() ||
                $request->wantsJson() ||
                $request->header('X-Requested-With') === 'XMLHttpRequest'
            ) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Error updating theme settings: ' . $e->getMessage(),
                    ],
                    500
                );
            }

            return toastError('Error updating theme settings: ' . $e->getMessage());
        }
    }
    
    /**
     * Update whatsapp settings
     */
    public function whatsappUpdate(Request $request)
    {
        $request->validate([
            'whatsapp_status' => 'required',
            'whatsapp_url' => 'required',
            'whatsapp_api_key' => 'required',
        ]);

        $this->updateSetting('whatsapp_status', $request->whatsapp_status);
        $this->updateSetting('whatsapp_url', $request->whatsapp_url);
        $this->updateSetting('whatsapp_api_key', $request->whatsapp_api_key);

        return toastSuccess('Whatsapp settings updated successfully!');
    }

    /**
     * Update user settings
     */
    public function userUpdate(Request $request)
    {
        $request->validate([
            'default_user_role' => 'nullable|string|max:255',
            'max_login_attempts' => 'nullable|integer|min:1|max:10',
        ]);

        // Update user settings
        $this->updateSetting('default_user_role', $request->default_user_role);
        $this->updateSetting(
            'user_registration_enabled',
            $request->has('user_registration_enabled') ? '1' : '0'
        );
        $this->updateSetting(
            'email_verification_required',
            $request->has('email_verification_required') ? '1' : '0'
        );
        $this->updateSetting('max_login_attempts', $request->max_login_attempts ?? 5);

        return toastSuccess('User settings updated successfully!');
    }

    /**
     * Helper method to update a setting
     */
    private function updateSetting($key, $value)
    {
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Helper method to get a setting value
     */
    private function getSetting($key)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : null;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateResource(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
