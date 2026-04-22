<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'kelas'    => 'nullable',
            'jurusan'  => 'nullable',
            'nisn'     => 'nullable|unique:users',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password, // ✅ cast 'hashed' di model yg hash otomatis
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
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'kelas'    => 'nullable',
            'jurusan'  => 'nullable',
            'nisn'     => 'nullable|unique:users,nisn,' . $user->id,
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'kelas'   => $request->kelas,
            'jurusan' => $request->jurusan,
            'nisn'    => $request->nisn,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password; // ✅ biarkan cast yg hash
        }

        $user->update($data);

        return back()->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}