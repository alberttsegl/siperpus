<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';
    protected $primaryKey = 'no_nota';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_nota',
        'tgl_nota',
        'id_distributor',
        'total_bayar',
    ];

    // relasi ke distributor
    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'id_distributor');
    }

    // relasi ke detail pembelian
    public function details()
    {
        return $this->hasMany(PurchaseDetail::class, 'no_nota', 'no_nota');
    }
}
