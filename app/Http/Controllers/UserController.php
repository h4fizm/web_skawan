<?php

namespace App\Http\Controllers;

use App\Jobs\SendVerifiedParticipantNotification;
use App\Models\Bill;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $roleNames = ['ppl', 'bendahara', 'pelanggan', 'yayasan'];
        // $roleNames = ['admin', 'pelanggan'];
        $roleNames = [];

        if ($request->ajax()) {
            try {
                $usersWithRoles = User::whereHas('roles', function ($query) use ($roleNames) {
                    $query->whereNotIn('name', $roleNames);
                })
                    ->with('roles')
                    ->get();

                return formatResponse('success', 'Data berhasil diambil!', $usersWithRoles, null, Response::HTTP_OK);
            } catch (Exception $e) {
                Log::error('Error retrieve users data: ' . $e->getMessage());
                return formatResponse('error', 'Gagal mengambil', null, $e->getMessage(), 500);
            }
        }

        $roles = Role::whereNotIn('name', $roleNames)->get();
        return view('manage-users.index', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Password::defaults()],
                'role' => 'required',
                'rt_rw' => ['nullable', 'regex:/^\d{3}\/\d{3}$/'],
                'kartu_identitas' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            if ($validator->fails()) {
                return formatResponse('error', 'Validasi gagal', null, $validator->errors(), 422);
            }
            DB::beginTransaction();
            $data['kartu_identitas'] = null;
            if ($request->hasFile('kartu_identitas')) {
                $file = $request->file('kartu_identitas');
                $filePath = $file->store('kartu_identitas_pelanggan', 'public');
                $data['kartu_identitas'] = $filePath; // Save the file path in the notes field
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rt_rw' => $request->rt_rw,
                'kartu_identitas' => $data['kartu_identitas'],
            ]);
            $roles = [$request->role];
            if ($request->role == 'pelanggan') {
                // Create the initial bill for the user
            } else {
                if ($request->role == 'yayasan') {
                    $roles[] = 'pelanggan';
                }
                $user->syncRoles($roles);
            }
            DB::commit();
            return formatResponse('success', 'Data berhasil disimpan!', $user, null, Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error store employee data: ' . $e->getMessage());
            return formatResponse('error', 'Gagal menyimpan', null, $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email'],
                'role' => 'nullable',
                'rt_rw' => ['nullable', 'regex:/^\d{3}\/\d{3}$/'],
                'kartu_identitas' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ] + ($request->filled('password') ? ['password' => ['required', 'confirmed', Password::defaults()]] : []));

            if ($validator->fails()) {
                return formatResponse('error', 'Validasi gagal', null, $validator->errors(), 422);
            }
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $data['kartu_identitas'] = null;
            if ($request->hasFile('kartu_identitas')) {
                // Delete old file if it exists
                if ($user->kartu_identitas_raw_path && Storage::disk('public')->exists($user->kartu_identitas_raw_path)) {
                    Storage::disk('public')->delete($user->kartu_identitas_raw_path);
                }
                $file = $request->file('kartu_identitas');
                $filePath = $file->store('kartu_identitas_pelanggan', 'public');
                $data['kartu_identitas'] = $filePath; // Save the file path in the notes field
            }
            if ($user->roles->isNotEmpty()) {
                $userRole = $user->roles->first()->name; // Access the name of the first role
            } else {
                $userRole = null; // Handle the case where the user has no roles
            }
            $roles = [$request->role];
            if ($request->role == 'pelanggan' && ($userRole != 'pelanggan' || $userRole == null)) {
                // Create the initial bill for the user
            } else {
                if ($request->role == 'yayasan') {
                    $roles[] = 'pelanggan';
                }
                $user->syncRoles($roles);
            }
            $dataToUpdate = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
                'rt_rw' => $request->rt_rw,
            ];

            if ($request->hasFile('kartu_identitas')) {
                $dataToUpdate['kartu_identitas'] = $data['kartu_identitas'];
            }

            $user->update($dataToUpdate);


            DB::commit();
            return formatResponse('success', 'Data berhasil diperbarui!', $user, null, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error update employee data: ' . $e->getMessage());
            return formatResponse('error', 'Gagal memperbarui', null, $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            if ($user->kartu_identitas_raw_path && Storage::disk('public')->exists($user->kartu_identitas_raw_path)) {
                Storage::disk('public')->delete($user->kartu_identitas_raw_path);
            }
            $user->delete();
            DB::commit();
            return formatResponse('success', 'Data berhasil dihapus!', null, null, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error delete user data: ' . $e->getMessage());
            return formatResponse('error', 'Gagal menghapus', null, $e->getMessage(), 500);
        }
    }

    public function login_as_participant($id)
    {
        $user = User::findOrFail($id);
        Session::put('admin-data', auth()->user()->id);
        Session::regenerate();
        Auth::login($user);
        return redirect()->route('profile.index');
    }

    public function logout_and_revert()
    {
        if (Session::has('admin-data')) {
            $adminId = Session::get('admin-data');
            $admin = User::findOrFail($adminId);

            Auth::logout();
            Session::regenerate();
            Auth::login($admin);

            Session::forget('admin-data');
            return redirect()->route('view-participant');
        } else {
            return redirect()->route('products.index')->with('error', 'Tidak ditemukan data sesi admin.');
        }
    }

    public function verif($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->syncRoles('pelanggan');
            return formatResponse('success', 'Data berhasil diperbarui!', null, null, Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error verifying user: ' . $e->getMessage());
            return formatResponse('error', 'Gagal verifikasi', null, $e->getMessage(), 500);
        }
    }
}
