<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        DB::transaction(function () use ($request) {
            $subtotal = $request->jumlah_beli * $request->harga_beli;

            DB::table('purchases')->insert([
                'no_nota' => $request->no_nota,
                'tgl_nota' => $request->tgl_nota,
                'id_distributor' => $request->id_distributor,
                'total_bayar' => $request->total_bayar ?? $subtotal,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('purchase_details')->insert([
                'no_nota' => $request->no_nota,
                'kdbuku' => $request->kdbuku,
                'jumlah_beli' => $request->jumlah_beli,
                'harga_beli' => $request->harga_beli,
                'subtotal' => $request->subtotal ?? $subtotal,
            ]);
            
            DB::table('books')->where('kdbuku', $request->kdbuku)->increment('stock', $request->jumlah_beli);
        });

        return redirect()->route('purchases.index')->with('success', 'Transaksi Berhasil Disimpan!');
    }

    public function edit($no_nota)
    {
        $purchase = DB::table('purchases')->where('no_nota', $no_nota)->first();
        $detail = DB::table('purchase_details')->where('no_nota', $no_nota)->first();
        $distributors = DB::table('distributors')->get();
        $books = DB::table('books')->get(); 

        return view('purchases.edit', [
            'title' => 'Edit Transaksi',
            'purchase' => $purchase,
            'detail' => $detail,
            'distributors' => $distributors,
            'books' => $books
        ]);
    }

    public function update(Request $request, $no_nota)
    {
        DB::transaction(function () use ($request, $no_nota) {
            $subtotal = $request->jumlah_beli * $request->harga_beli;

            DB::table('purchases')->where('no_nota', $no_nota)->update([
                'tgl_nota' => $request->tgl_nota,
                'id_distributor' => $request->id_distributor,
                'total_bayar' => $request->total_bayar ?? $subtotal,
                'updated_at' => now(),
            ]);

            DB::table('purchase_details')->where('no_nota', $no_nota)->update([
                'kdbuku' => $request->kdbuku,
                'jumlah_beli' => $request->jumlah_beli,
                'harga_beli' => $request->harga_beli,
                'subtotal' => $request->subtotal ?? $subtotal,
            ]);
        });

        return redirect()->route('purchases.index')->with('success', 'Data Diperbarui!');
    }

    public function destroy($no_nota)
{
    try {
        DB::transaction(function () use ($no_nota) {
            $nota = (string)$no_nota;

            // 1. Ambil detail untuk balikin stok
            $detail = DB::table('purchase_details')->where('no_nota', $nota)->first();
            
            if ($detail) {
                DB::table('books')
                    ->where('kdbuku', $detail->kdbuku)
                    ->decrement('stock', $detail->jumlah_beli);
            }

            // 2. HAPUS DENGAN CARA INI (WAJIB SAMA)
            // Kita kasih where dulu baru delete, biar dia gak nyari kolom 'id'
            DB::table('purchase_details')->where('no_nota', $nota)->delete();
            DB::table('purchases')->where('no_nota', $nota)->delete();
        });

        return redirect()->route('purchases.index')->with('success', 'Data Berhasil Dihapus!');
    } catch (\Exception $e) {
        // Balikin error asli biar lo bisa liat kalau masih gagal
        return redirect()->route('purchases.index')->with('error', 'Gagal: ' . $e->getMessage());
    }
}
}