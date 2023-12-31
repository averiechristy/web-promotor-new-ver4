<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reward = Reward::orderBy('created_at', 'desc')->get();
        
        return view ('admin.reward.index',[
            'reward' => $reward,
        ]);
    }

    public function create()
    {
        $role = UserRole::all();
        return view ('admin.reward.create',[
            'role' => $role,
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
  

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul_reward' => 'required|string',
            'poin_reward' => 'required|integer',
            'gambar_reward' => 'image|mimes:jpeg,png,jpg,gif|max:5048', // Validasi file gambar
            'deskripsi_reward' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kuota' => 'required|integer',

        ], [
          
            'gambar_reward.required' => 'Upload Gambar Produk dahulu.',
            'gambar_reward.image' => 'File harus berupa gambar.',
            'gambar_reward.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif.',
            'gambar_reward.max' => 'Ukuran gambar tidak boleh lebih dari 5MB.',
        ]);
    
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; // Ganti "name" sesuai dengan kolom yang sesuai di tabel pengguna.
       
        $nm = $request->gambar_reward;
        $namaFile = $nm->getClientOriginalName();
        $nm->move(public_path().'/img', $namaFile);

        // Membuat reward
        $reward = new Reward([
            'judul_reward' => $request->input('judul_reward'),
            'poin_reward' => $request->input('poin_reward'),
            'tanggal_mulai' => $request->input('tanggal_mulai'),
            'gambar_reward' => $namaFile,
            'kuota' => $request->input('kuota'),
            'deskripsi_reward' => $request->input('deskripsi_reward'),
            'tanggal_selesai' => $request->input('tanggal_selesai'),
            'role_id' => $request->input('role_id'),
           'created_by' => $loggedInUsername,
        ]);
    
        // Menghitung status berdasarkan tanggal mulai dan tanggal selesai

    
    
        // Menyimpan reward
       
        $reward->save();
    
        $request->session()->flash('success', 'Reward berhasil ditambahkan.');

        return redirect(route('admin.reward.index'))->withInput();
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Reward::find($id);

        $role = UserRole::all();

        $selesai = Carbon::parse($data->tanggal_selesai)->endOfDay();
    $mulai = Carbon::parse($data->tanggal_mulai);
    $sekarang = Carbon::now();

    if ($selesai->isPast()) {
        $status = 'Berakhir';
    } elseif ($sekarang >= $mulai && $sekarang <= $selesai) {
        $status = 'Sedang Berjalan';
    } elseif ($sekarang < $mulai) {
        $status = 'Akan Datang';
    } else {
        $status = 'Tidak Aktif';
    }
       
        return view('admin.reward.edit', [
            'data' => $data,
            'role' => $role,
            'status' => $status,
        ]);


    }

    public function detailreward($id) {
        // Ambil data dari tabel PackageIncome berdasarkan id
        $data = Reward::find($id);
    
        // Ambil semua data dari tabel PackageDetail
    
        // Ambil data produk yang terhubung dengan tabel PackageDetail
    
        return view('admin.reward.detail', [
            'data' => $data,
            
        ]);
    }


    /**
     * Show the form for editing the specified resource.getRankForUser
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */public function updatereward(Request $request, $id)
{
    $reward = Reward::find($id);

    if (!$reward) {
        return redirect(route('admin.reward.index'))->with('error', 'Reward tidak ditemukan.');
    }

    // Validasi input
    $request->validate([
        'judul_reward' => 'required|string',
        'poin_reward' => 'required|integer',
        'gambar_reward' => 'image|mimes:jpeg,png,jpg,gif|max:5048', // Validasi file gambar
        'deskripsi_reward' => 'required',
        'tanggal_mulai' => 'required|date',
        'kuota' => 'required|integer',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
    ], [
      
        'gambar_reward.required' => 'Upload Gambar Produk dahulu.',
        'gambar_reward.image' => 'File harus berupa gambar.',
        'gambar_reward.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif.',
        'gambar_reward.max' => 'Ukuran gambar tidak boleh lebih dari 5MB.',
    ]);

    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama;

    if ($request->hasFile('gambar_reward')) {
        $path = public_path('img');

        if ($reward->gambar_reward != '' && $reward->gambar_reward != null) {
            $file_old = $path.'/'.$reward->gambar_reward;
            unlink($file_old);
        }

        $file = $request->file('gambar_reward');
        $filename = $file->getClientOriginalName();
        $file->move($path, $filename);
    } else {
        $filename = $reward->gambar_reward;
    }

   
    $reward->update([
        'judul_reward' => $request->input('judul_reward'),
        'poin_reward' => $request->input('poin_reward'),
        'deskripsi_reward' => $request->input('deskripsi_reward'),
        'tanggal_mulai' => $request->input('tanggal_mulai'),
        'tanggal_selesai' => $request->input('tanggal_selesai'),
        'role_id' => $request->input('role_id'),
        'updated_by' => $loggedInUsername,
        'kuota'=>$request->input('kuota'),
        'gambar_reward' => $filename,
    ]);

    $request->session()->flash('success', 'Reward berhasil diedit.');

    return redirect(route('admin.reward.index'))->withInput();
}
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
       $reward = Reward::find($id);
       $reward->delete();

        $request->session()->flash('error', "Reward berhasil dihapus.");

        return redirect(route('admin.reward.index'));
    }
}
