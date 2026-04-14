<?php

namespace App\Http\Controllers;

use App\Models\Borrowers; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class BorrowerController extends Controller
{
    public function index() {
        return view('borrowers.index', [
            'title' => 'Daftar Peminjam',
            'borrowers' => Borrowers::all()
        ]);
    }

    public function create() {
        return view('borrowers.create', ['title' => 'Tambah Peminjam']);
    }

    public function store(Request $request) {
        $request->validate([
            'nama_peminjam' => 'nullable|max:30',
            'jk'            => 'required|in:L,P',
            'email'         => 'required|email|unique:borrowers,email',
            'password'      => 'required|min:6',
            'status'        => 'required|in:siswa,guru,tendik,umum',
            'foto'          => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('borrowers', 'public');
        }

        Borrowers::create($data);
        return redirect()->route('borrowers.index')->with('success', 'Peminjam berhasil disimpan!');
    }

    public function edit($id) {
        $borrower = Borrowers::findOrFail($id); 
        return view('borrowers.edit', [
            'title' => 'Edit Peminjam',
            'borrowers' => $borrower
        ]);
    }

    public function update(Request $request, $id) {
        $borrower = Borrowers::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:borrowers,email,'.$id.',id_peminjam',
            'jk'    => 'required|in:L,P',
            'status'=> 'required|in:siswa,guru,tendik,umum',
        ]);

        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('foto')) {
            if ($borrower->foto) Storage::disk('public')->delete($borrower->foto);
            $data['foto'] = $request->file('foto')->store('borrowers', 'public');
        }

        $borrower->update($data);
        return redirect()->route('borrowers.index')->with('success', 'Data diperbarui!');
    }

    public function destroy($id) {
        $borrower = Borrowers::findOrFail($id);
        if ($borrower->foto) Storage::disk('public')->delete($borrower->foto);
        $borrower->delete();
        return redirect()->route('borrowers.index')->with('success', 'Data dihapus!');
    }
}