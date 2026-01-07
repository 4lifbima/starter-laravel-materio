<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user()->load(['profile', 'roles']);

        return view('content.profile.edit', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:500'],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        $oldData = $user->toArray();

        // Update user
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->profile->avatar_path) {
                Storage::disk('public')->delete($user->profile->avatar_path);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->profile->update(['avatar_path' => $path]);
        }

        // Update profile
        $user->profile->update([
            'phone_number' => $validated['phone_number'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        // Log activity
        ActivityLog::log(
            'profile',
            'Profile updated',
            $user,
            $user,
            ['old' => $oldData, 'new' => $user->fresh()->toArray()]
        );

        return redirect()->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user's avatar.
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:2048'], // 2MB max
        ]);

        $user = Auth::user();

        // Delete old avatar if exists
        if ($user->profile && $user->profile->avatar_path) {
            Storage::disk('public')->delete($user->profile->avatar_path);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        
        // Ensure profile exists
        if (!$user->profile) {
            $user->profile()->create(['avatar_path' => $path]);
        } else {
            $user->profile->update(['avatar_path' => $path]);
        }

        // Log activity
        ActivityLog::log(
            'profile',
            'Avatar updated',
            $user,
            $user
        );

        return redirect()->route('profile.edit')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Log activity
        ActivityLog::log(
            'profile',
            'Password changed',
            $user,
            $user
        );

        return redirect()->route('profile.edit')
            ->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Update user preferences.
     */
    public function updatePreferences(Request $request)
    {
        $validated = $request->validate([
            'theme' => ['nullable', 'string', 'in:light,dark,auto'],
            'language' => ['nullable', 'string', 'in:id,en'],
            'notifications' => ['nullable', 'boolean'],
        ]);

        $user = Auth::user();

        foreach ($validated as $key => $value) {
            if ($value !== null) {
                $user->profile->setPreference($key, $value);
            }
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Preferensi berhasil diperbarui.');
    }
}
