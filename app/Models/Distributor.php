<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $table = 'distributors';
    protected $primaryKey = 'id_distributor';
    public $timestamps = false;

    protected $fillable = ['nama_distributor', 'alamat', 'no_telpon'];

    public function purchases()
{
    return $this->hasMany(Purchases::class, 'id_distributor');
}



}
