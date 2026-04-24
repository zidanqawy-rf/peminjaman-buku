<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Validasi tambahan untuk field data siswa
        $request->validate([
            'nisn'    => ['required', 'digits:10', 'unique:users,nisn,' . $request->user()->id],
            'kelas'   => ['required', 'string', 'max:20'],
            'jurusan' => ['required', 'string', 'max:50'],
        ]);

        // Fill field dari ProfileUpdateRequest (name, email)
        $request->user()->fill($request->validated());

        // Set field data siswa secara manual
        $request->user()->nisn    = $request->nisn;
        $request->user()->kelas   = $request->kelas;
        $request->user()->jurusan = $request->jurusan;

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}