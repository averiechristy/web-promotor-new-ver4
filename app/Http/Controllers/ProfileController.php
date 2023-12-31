<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Storage;

class ProfileController extends Controller
{
    public function updateAvatar(Request $request)
{
    $this->validate($request, [
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048', // Validasi file gambar

    ], [
        'avatar.required' => 'Pilih gambar profil untuk diunggah.',
        'avatar.image' => 'File harus berupa gambar.',
        'avatar.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif.',
        'avatar.max' => 'Ukuran gambar tidak boleh lebih dari 5MB.',

    ]);


    $user = Auth::user();

    // Handle profile image upload
    if ($request->hasFile('avatar')) {
        $path = public_path('img');
       

        // Upload gambar baru
        $file = $request->file('avatar');
        $filename = $file->getClientOriginalName();
        $file->move($path, $filename);

        // Update nama gambar pada record
        $user->update(['avatar' => $filename]);

    }

    return redirect()->back()->with('error', 'Tidak ada gambar yang diupload');
}


public function deletePhoto(Request $request)
{
    $user = User::find(auth()->user()->id);

    if ($user->avatar !== 'default.jpg') {
        $path = public_path('img');
        $filename = $user->avatar;

        // Hapus gambar dari penyimpanan
        Storage::delete($path . '/' . $filename);

        // Update nama gambar pada record
        $user->update(['avatar' => 'default.jpg']);
    }

    return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
}
}
