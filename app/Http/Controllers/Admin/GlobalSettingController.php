<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\GlobalSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GlobalSettingController extends Controller
{
    /**
     * Display a listing of settings.
     */
    public function index()
    {
        $groupedSettings = GlobalSetting::all()->groupBy('group');

        return view('content.admin.settings.index', compact('groupedSettings'));
    }

    /**
     * Show the form for creating a new setting.
     */
    public function create()
    {
        $groups = GlobalSetting::distinct()->pluck('group');

        return view('content.admin.settings.create', compact('groups'));
    }

    /**
     * Store a newly created setting.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:global_settings,key'],
            'value' => ['nullable', 'string'],
            'type' => ['required', Rule::in(['text', 'boolean', 'json'])],
            'group' => ['required', 'string', 'max:255'],
        ]);

        $setting = GlobalSetting::set(
            $validated['key'],
            $validated['value'],
            $validated['type'],
            $validated['group']
        );

        // Log activity
        ActivityLog::log(
            'settings',
            "Setting {$setting->key} created",
            $setting,
            Auth::user(),
            ['value' => $validated['value']]
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified setting.
     */
    public function edit(GlobalSetting $setting)
    {
        $groups = GlobalSetting::distinct()->pluck('group');

        return view('content.admin.settings.edit', compact('setting', 'groups'));
    }

    /**
     * Update the specified setting.
     */
    public function update(Request $request, GlobalSetting $setting)
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:global_settings,key,' . $setting->id],
            'value' => ['nullable', 'string'],
            'type' => ['required', Rule::in(['text', 'boolean', 'json'])],
            'group' => ['required', 'string', 'max:255'],
        ]);

        $oldValue = $setting->value;

        $setting->update([
            'key' => $validated['key'],
            'value' => $validated['value'],
            'type' => $validated['type'],
            'group' => $validated['group'],
        ]);

        // Log activity
        ActivityLog::log(
            'settings',
            "Setting {$setting->key} updated",
            $setting,
            Auth::user(),
            ['old' => $oldValue, 'new' => $validated['value']]
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting berhasil diperbarui.');
    }

    /**
     * Remove the specified setting.
     */
    public function destroy(GlobalSetting $setting)
    {
        // Log activity before deletion
        ActivityLog::log(
            'settings',
            "Setting {$setting->key} deleted",
            null,
            Auth::user(),
            ['deleted_setting' => $setting->toArray()]
        );

        $setting->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting berhasil dihapus.');
    }
}
