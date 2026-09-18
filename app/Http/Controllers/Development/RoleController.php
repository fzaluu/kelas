<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Models\Core\Role;
use App\Models\Core\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Tampilkan daftar role beserta jumlah permission & penggunanya.
     */
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('id', 'asc')->get();
        $permissions = Permission::all()->groupBy('resource');

        return view('pages.development.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Form edit permission untuk role tertentu.
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        
        // Kelompokkan permission berdasarkan resource
        $permissions = Permission::all()->groupBy('resource');
        
        // Ambil ID permission yang sedang dimiliki role ini
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('pages.development.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update/Sync permission milik role.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Proteksi role Development (tidak boleh diubah permission master-nya)
        if ($role->slug === 'development') {
            return redirect()->route('development.roles.index')
                ->with('error', 'Hak akses Role Development bersifat absolut dan tidak dapat diubah!');
        }

        $request->validate([
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        DB::transaction(function () use ($request, $role) {
            $syncData = [];
            if ($request->has('permissions')) {
                foreach ($request->permissions as $permId) {
                    $syncData[$permId] = [
                        'scope' => 'class', // Default scope
                    ];
                }
            }

            $role->permissions()->sync($syncData);
        });

        return redirect()->route('development.roles.index')
            ->with('success', "Permission untuk Role {$role->name} berhasil diperbarui!");
    }
}