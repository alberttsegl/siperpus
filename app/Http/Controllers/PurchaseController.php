<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = DB::table('purchases as p')
            ->join('distributors as d', 'p.id_distributor', '=', 'd.id_distributor')
            ->join('purchase_details as pd', 'p.no_nota', '=', 'pd.no_nota')
            ->join('books as b', 'pd.kdbuku', '=', 'b.kdbuku')
            ->select('p.*', 'd.nama_distributor', 'd.no_telpon', 'pd.jumlah_beli', 'pd.harga_beli', 'pd.subtotal', 'b.judul')
            ->get();

        return view('purchases.index', [
            'title' => 'Daftar Pembelian',
            'purchases' => $purchases 
        ]);
    }

    public function create()
    {
        $distributors = DB::table('distributors')->get();
        $books = DB::table('books')->get();

        return view('purchases.create', [
            'title' => 'Input Transaksi Pembelian',
            'distributors' => $distributors,
            'books' => $books
        ]);
    }

    public function store(Request $request)
    {
        $qty = $request->jumlah_beli ?? 0;
        $price = $request->harga_beli ?? 0;
        $calculatedSubtotal = $qty * $price;

        DB::transaction(function () use ($request, $calculatedSubtotal) {
            DB::table('purchases')->insert([
                'no_nota' => $request->no_nota,
                'tgl_nota' => $request->tgl_nota,
                'id_distributor' => $request->id_distributor,
                'total_bayar' => $request->total_bayar ?? $calculatedSubtotal,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('purchase_details')->insert([
                'no_nota' => $request->no_nota,
                'kdbuku' => $request->kdbuku,
                'jumlah_beli' => $request->jumlah_beli,
                'harga_beli' => $request->harga_beli,
                'subtotal' => $request->subtotal ?? $calculatedSubtotal,
            ]);
            
            DB::table('books')->where('kdbuku', $request->kdbuku)->increment('stock', $request->jumlah_beli);
        });

        return redirect()->route('purchases.index')->with('success', 'Berhasil!');
    }

    // --- TAMBAHKAN FUNGSI EDIT DI BAWAH INI ---
    public function edit($id)
{
    $purchase = DB::table('purchases')->where('no_nota', $id)->first();
    $detail = DB::table('purchase_details')->where('no_nota', $id)->first();

    $distributors = DB::table('distributors')->get();
    // Ambil semua buku
    $books = DB::table('books')->get(); 

    return view('purchases.edit', [
        'title' => 'Edit Transaksi Pembelian',
        'purchase' => $purchase,
        'detail' => $detail,
        'distributors' => $distributors,
        'books' => $books
    ]);
}

    // --- TAMBAHKAN FUNGSI UPDATE DI BAWAH INI ---
    public function update(Request $request, $id)
    {
        $qty = $request->jumlah_beli ?? 0;
        $price = $request->harga_beli ?? 0;
        $calculatedSubtotal = $qty * $price;

        DB::transaction(function () use ($request, $id, $calculatedSubtotal) {
            // 1. Update Tabel Utama (Purchases)
            DB::table('purchases')->where('no_nota', $id)->update([
                'tgl_nota' => $request->tgl_nota,
                'id_distributor' => $request->id_distributor,
                'total_bayar' => $request->total_bayar ?? $calculatedSubtotal,
                'updated_at' => now(),
            ]);

            // 2. Update Tabel Detail (Purchase Details)
            DB::table('purchase_details')->where('no_nota', $id)->update([
                'kdbuku' => $request->kdbuku,
                'jumlah_beli' => $request->jumlah_beli,
                'harga_beli' => $request->harga_beli,
                'subtotal' => $request->subtotal ?? $calculatedSubtotal,
            ]);
        });

        return redirect()->route('purchases.index')->with('success', 'Data Transaksi Berhasil Diperbarui!');
    }
}