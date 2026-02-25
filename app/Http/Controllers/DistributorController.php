<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distributor;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $distributors = Distributor::all(); // ambil semua data distributor
        return view('distributors.index', [
            'title' => 'Distributor',
            'distributors' => $distributors
        ]);
    }

    public function create()
    {
        return view('distributors.create', [
            'title' => 'Tambah Distributor'
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_distributor' => 'required|string|max:255',
        'alamat'          => 'required|string|max:500',
        'no_telpon'       => 'required|string|max:20',
    ]);

    Distributor::create([
        'nama_distributor' => $request->nama_distributor,
        'alamat'           => $request->alamat,
        'no_telpon'        => $request->no_telpon,
    ]);

    return redirect()->route('distributors.index')->with('success', 'Distributor berhasil ditambahkan');
}

    public function edit($id)
{
    $distributor = Distributor::findOrFail($id);
    return view('distributors.edit', [
        'distributor' => $distributor,
        'title' => 'Edit Distributor' 
    ]);
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_distributor' => 'required|max:50',
            'alamat' => 'nullable|max:200',
            'no_telpon' => 'nullable|max:15',
        ]);

        $distributor = Distributor::findOrFail($id);
        $distributor->update($request->all());

        return redirect()->route('distributors.index')->with('success', 'Distributor berhasil diupdate');
    }

    public function destroy($id)
    {
        $distributor = Distributor::findOrFail($id);
        $distributor->delete();

        return redirect()->route('distributors.index')->with('success', 'Distributor berhasil dihapus');
    }
}