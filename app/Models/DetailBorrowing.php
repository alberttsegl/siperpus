<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBorrowing extends Model
{
    protected $table = 'detail_borrowings';

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'no_pinjam',
        'kdbuku',
        'tgl_kembali',
        'denda_perhari',
        'jumlah_terlambat',
        'bayar_denda',
        'jumlah_pinjam',
        'status_pinjam',
        'keterangan',
    ];
}
