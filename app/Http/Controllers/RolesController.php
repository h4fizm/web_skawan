<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $roles = Role::with('permissions')->get();
                return formatResponse('success', 'Data berhasil diambil!', $roles, null, Response::HTTP_OK);
            } catch (Exception $e) {
                Log::error('Error retrieve roles data: ' . $e->getMessage());
                return formatResponse('error', 'Gagal mengambil', null, $e->getMessage(), 500);
            }
        }
        $permissions = Permission::all();
        return view('rbac.roles', compact('permissions'));
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
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255', 'unique:' . Role::class],
            ]);

            if ($validator->fails()) {
                return formatResponse('error', 'Validasi gagal', null, $validator->errors(), 422);
            }

            $role = Role::create(['name' => $request->name]);
            $role->syncPermissions($request->input('permission'));

            return formatResponse('success', 'Data berhasil dissimpan!', $role, null, Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error('Error store role data: ' . $e->getMessage());
            return formatResponse('error', 'Gagal menyimpan', null, $e->getMessage(), 500);
        }
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
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return formatResponse('error', 'Validasi gagal', null, $validator->errors(), 422);
            }

            $role = Role::findById($id);
            $role->name = $request->name;
            $role->update();
            $role->syncPermissions($request->input('permission'));

            return formatResponse('success', 'Data berhasil diperbarui!', $role, null, Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error update role data: ' . $e->getMessage());
            return formatResponse('error', 'Gagal memperbarui', null, $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::findById($id);
            $role->delete();
            return formatResponse('success', 'Data berhasil dihapus!', null, null, Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error delete role data: ' . $e->getMessage());
            return formatResponse('error', 'Gagal menghapus', null, $e->getMessage(), 500);
        }
    }
}
