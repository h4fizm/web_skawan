<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function getpermissions()
    {
        // Add logic as needed
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $permissions = Permission::all();
                return formatResponse('success', 'Data Berhasil Diambil!', $permissions, null, Response::HTTP_OK);
            } catch (Exception $e) {
                Log::error('Error retrieving permissions data: ' . $e->getMessage());
                return formatResponse('error', 'Gagal mengambil', null, $e->getMessage(), 500);
            }
        }
        return view('admin.rbac.permission');
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
                'name' => ['required', 'string', 'max:255', 'unique:' . Permission::class],
            ]);

            if ($validator->fails()) {
                return formatResponse('error', 'Validasi Gagal', null, $validator->errors(), 422);
            }

            $permission = Permission::create(['name' => $request->name]);

            return formatResponse('success', 'Data Berhasil Disimpan!', $permission, null, Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error('Error storing permission data: ' . $e->getMessage());
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
    public function update(Request $request, Permission $permission)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return formatResponse('error', 'Validasi Gagal', null, $validator->errors(), 422);
            }

            $permission->name = $request->name;
            $permission->update();

            return formatResponse('success', 'Data Berhasil Diperbarui!', $permission, null, Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error updating permission data: ' . $e->getMessage());
            return formatResponse('error', 'Gagal memperbarui', null, $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();
            return formatResponse('success', 'Data berhasil dihapus!', null, null, Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error deleting permission data: ' . $e->getMessage());
            return formatResponse('error', 'Gagal menghapus', null, $e->getMessage(), 500);
        }
    }
}
