<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\MasterKua;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function __construct()
    {
        // Hanya Admin yang bisa mengakses controller ini
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource (all users).
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Definisikan role yang tersedia
        $roles = ['admin', 'petugas_kua', 'petugas_pa'];
        $master_kua = MasterKua::all();
        return view('admin.users.create', compact('roles', 'master_kua'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'petugas_kua', 'petugas_pa'])],
            'master_kua_id' => 'nullable|required_if:role,petugas_kua|exists:master_kua,id',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'kua_id' => $request->master_kua_id,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified user. (Opsional, bisa dilewati atau digabung ke edit)
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = ['admin', 'petugas_kua', 'petugas_pa'];
        $master_kua = MasterKua::all();

        return view('admin.users.edit', compact('user', 'roles', 'master_kua'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8', // Password optional saat update
            'password_confirmation' => ['nullable', 'string', 'min:8', 'same:password'], // Validasi konfirmasi
            'role' => ['required', Rule::in(['admin', 'petugas_kua', 'petugas_pa'])],
            'master_kua_id' => 'nullable|required_if:role,petugas_kua|exists:master_kua,id',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->kua_id = $request->role == 'petugas_kua' ? $request->master_kua_id : null; 

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Pastikan admin tidak bisa menghapus akunnya sendiri
        if (Auth::id() == $user->id) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Akun pengguna berhasil dihapus.');
    }
}