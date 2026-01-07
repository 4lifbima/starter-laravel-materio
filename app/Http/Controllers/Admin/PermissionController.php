<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of permissions.
     */
    public function index()
    {
        $groupedPermissions = Permission::all()->groupBy(function ($permission) {
            $parts = explode('-', $permission->name);
            return $parts[1] ?? 'other';
        });

        return view('content.admin.permissions.index', compact('groupedPermissions'));
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create()
    {
        return view('content.admin.permissions.create');
    }

    /**
     * Store a newly created permission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ]);

        $permission = Permission::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        // Log activity
        ActivityLog::log(
            'permission',
            "Permission {$permission->name} created",
            $permission,
            Auth::user()
        );

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit(Permission $permission)
    {
        return view('content.admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission.
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name,' . $permission->id],
        ]);

        $oldName = $permission->name;
        $permission->update(['name' => $validated['name']]);

        // Log activity
        ActivityLog::log(
            'permission',
            "Permission updated from {$oldName} to {$permission->name}",
            $permission,
            Auth::user(),
            ['old' => $oldName, 'new' => $permission->name]
        );

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission berhasil diperbarui.');
    }

    /**
     * Remove the specified permission.
     */
    public function destroy(Permission $permission)
    {
        // Log activity before deletion
        ActivityLog::log(
            'permission',
            "Permission {$permission->name} deleted",
            null,
            Auth::user(),
            ['deleted_permission' => $permission->toArray()]
        );

        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission berhasil dihapus.');
    }
}
