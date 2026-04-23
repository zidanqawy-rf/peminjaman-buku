<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua user kecuali admin
        $users = User::where('role', '!=', 'admin')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'kelas'    => 'nullable|string|max:50',
            'jurusan'  => 'nullable|string|max:100',
            'nisn'     => 'nullable|string|unique:users,nisn',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password), // ✅ hash manual — aman di semua versi Laravel
            'role'     => 'user',
            'kelas'    => $request->kelas,
            'jurusan'  => $request->jurusan,
            'nisn'     => $request->nisn,
        ]);

        return back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'kelas'    => 'nullable|string|max:50',
            'jurusan'  => 'nullable|string|max:100',
            'nisn'     => 'nullable|string|unique:users,nisn,' . $user->id,
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'kelas'   => $request->kelas,
            'jurusan' => $request->jurusan,
            'nisn'    => $request->nisn,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password); // ✅ hash manual
        }

        $user->update($data);

        return back()->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        // Cegah hapus akun admin
        if ($user->role === 'admin') {
            return back()->with('error', 'Akun admin tidak dapat dihapus');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}