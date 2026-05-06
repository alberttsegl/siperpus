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
            ->orderBy('p.created_at', 'desc')
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
        // Langsung cari tanpa urldecode yang ribet
        $purchase = DB::table('purchases')->where('no_nota', $no_nota)->first();
        $detail = DB::table('purchase_details')->where('no_nota', $no_nota)->first();
        $distributors = DB::table('distributors')->get();
        $books = DB::table('books')->get(); 

        if (!$purchase) {
            return redirect()->route('purchases.index')->with('error', 'Data tidak ditemukan!');
        }

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

            // Balikin stok lama
            $oldDetail = DB::table('purchase_details')->where('no_nota', $no_nota)->first();
            if ($oldDetail) {
                DB::table('books')->where('kdbuku', $oldDetail->kdbuku)->decrement('stock', $oldDetail->jumlah_beli);
            }

            // Update Header
            DB::table('purchases')->where('no_nota', $no_nota)->update([
                'tgl_nota' => $request->tgl_nota,
                'id_distributor' => $request->id_distributor,
                'total_bayar' => $request->total_bayar ?? $subtotal,
                'updated_at' => now(),
            ]);

            // Update Detail
            DB::table('purchase_details')->where('no_nota', $no_nota)->update([
                'kdbuku' => $request->kdbuku,
                'jumlah_beli' => $request->jumlah_beli,
                'harga_beli' => $request->harga_beli,
                'subtotal' => $request->subtotal ?? $subtotal,
            ]);

            // Tambah stok baru
            DB::table('books')->where('kdbuku', $request->kdbuku)->increment('stock', $request->jumlah_beli);
        });

        return redirect()->route('purchases.index')->with('success', 'Data Diperbarui!');
    }

    public function destroy($no_nota)
{
    // Decode jika no_nota mengandung karakter spesial seperti '/'
    $no_nota = urldecode($no_nota);

    try {
        DB::transaction(function () use ($no_nota) {
            // 1. Ambil detail untuk mengembalikan stok buku
            $details = DB::table('purchase_details')->where('no_nota', $no_nota)->get();
            
            foreach ($details as $item) {
                // Pembelian dihapus = Stok buku harus berkurang kembali
                DB::table('books')
                    ->where('kdbuku', $item->kdbuku)
                    ->decrement('stock', $item->jumlah_beli);
            }

            // 2. Hapus dari purchase_details (tabel anak)
            DB::table('purchase_details')->where('no_nota', $no_nota)->delete();

            // 3. Hapus dari purchases (tabel induk)[cite: 7]
            DB::table('purchases')->where('no_nota', $no_nota)->delete();
        });

        return redirect()->route('purchases.index')->with('success', 'Transaksi Berhasil Dihapus!');

    } catch (\Exception $e) {
        // Jika gagal, kirim pesan error agar bisa kita baca di UI
        return redirect()->route('purchases.index')->with('error', 'Gagal: ' . $e->getMessage());
    }
}
}