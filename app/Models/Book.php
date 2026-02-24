<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $primaryKey = 'kdbuku';
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [
        'kdbuku',
        'judul',
        'jenis',
        'tahun_terbit',
        'penulis',
        'penerbit',
        'stock',
    ];

    // relasi ke purchase details
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class, 'kdbuku', 'kdbuku');
    }
}
