<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

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
        $data = $request->validated();  // Ambil semua data yang divalidasi
        $user = $request->user();  // Ambil user yang login
    
        // Isi kolom yang akan diupdate
        $user->fill($data);
    
        // Periksa apakah email diubah untuk set ulang waktu verified
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        // Tambahkan instansi ke data jika tersedia
        if ($request->has('instansi')) {
            $user->instansi = $request->instansi;
        }
    
        $user->save();  // Simpan ke database
    
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
