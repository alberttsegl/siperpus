<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $table = 'borrowings';

    protected $primaryKey = 'no_pinjam';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'no_pinjam',
        'tgl_pinjam',
        'id_peminjam',
        'total_bayar',
        'total_denda',
    ];
}
