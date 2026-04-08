<?php

namespace App\Http\Controllers;

use App\Models\Borrowers; // Pastikan pakai s
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BorrowerController extends Controller
{
    // Tampil Tabel
    public function index() {
        $data = [
            'title' => 'Borrower Management',
            'borrowers' => Borrowers::all() // Ganti ke Borrowers
        ];
        return view('borrowers.index', $data);
    }

    // Form Tambah
    public function create() {
        return view('borrowers.create', ['title' => 'Add Borrower']);
    }

    // Simpan Data
    public function store(Request $request) {
        $request->validate([
            'nama_peminjam' => 'required',
            'email' => 'required|email|unique:borrowers',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('borrowers', 'public');
        }

        Borrowers::create($data); // Pakai Borrowers
        return redirect()->route('borrowers.index')->with('success', 'Data berhasil ditambah!');
    }

    // Form Edit
    public function edit($id) {
        // Menggunakan id_peminjam sebagai primary key
        $borrower = Borrowers::findOrFail($id); 
        return view('borrowers.edit', [
            'title' => 'Edit Borrower',
            'borrowers' => $borrower
        ]);
    }

    // Update Data
    public function update(Request $request, $id) {
        $borrower = Borrowers::findOrFail($id); // Tadi lu tulis 'Borrower' (tanpa s), itu bakal error
        
        $data = $request->all();
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $borrower->update($data);
        return redirect()->route('borrowers.index')->with('success', 'Data berhasil diupdate!');
    }

    // Hapus Data
    public function destroy($id) {
        $borrower = Borrowers::findOrFail($id); // Tadi lu tulis 'Borrower' (tanpa s), itu bakal error
        $borrower->delete();
        return redirect()->route('borrowers.index')->with('success', 'Peminjam dihapus!');
    }
}