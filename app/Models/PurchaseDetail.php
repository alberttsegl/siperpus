<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $table = 'purchase_details';

    public $timestamps = false;

    protected $fillable = [
        'no_nota',
        'kdbuku',
        'jumlah_beli',
        'harga_beli',
        'subtotal',
    ];

    // relasi ke purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'no_nota', 'no_nota');
    }

    // relasi ke book
    public function book()
    {
        return $this->belongsTo(Book::class, 'kdbuku', 'kdbuku');
    }
}
