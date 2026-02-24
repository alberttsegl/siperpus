<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('books.index', [
            'title' => 'Books',
            'books' => Book::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create', [
            'title' => 'Books'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required',
            'jenis'        => 'required',
            'tahun_terbit' => 'required',
            'penulis'      => 'required',
            'penerbit'     => 'required',
            'stock'        => 'required|integer|min:1',
        ]);

        $book = new Book();

        $last = Book::orderBy('kdbuku', 'desc')->first();
        if ($last) {
            $num = (int) substr($last->kdbuku, 2) + 1;
        } else {
            $num = 1;
        }

        $book->kdbuku = 'BK' . str_pad($num, 8, '0', STR_PAD_LEFT);
        $book->judul        = $request->judul;
        $book->jenis        = $request->jenis;
        $book->tahun_terbit = $request->tahun_terbit;
        $book->penulis      = $request->penulis;
        $book->penerbit     = $request->penerbit;
        $book->stock        = $request->stock;

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Biasanya untuk detail buku
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Cari berdasarkan kdbuku (parameter $id diambil dari URL)
        $book = Book::where('kdbuku', $id)->firstOrFail();

        return view('books.edit', [
            'title' => 'Edit Book',
            'book'  => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul'        => 'required',
            'jenis'        => 'required',
            'tahun_terbit' => 'required',
            'penulis'      => 'required',
            'penerbit'     => 'required',
            'stock'        => 'required|integer|min:1',
        ]);

        // Cari berdasarkan kdbuku
        $book = Book::where('kdbuku', $id)->firstOrFail();

        $book->judul        = $request->judul;
        $book->jenis        = $request->jenis;
        $book->tahun_terbit = $request->tahun_terbit;
        $book->penulis      = $request->penulis;
        $book->penerbit     = $request->penerbit;
        $book->stock        = $request->stock;

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::where('kdbuku', $id)->firstOrFail();
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
}