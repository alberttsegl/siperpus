<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowers extends Model
{
    protected $table = 'borrowers';
    protected $primaryKey = 'id_peminjam';

    public $timestamps = false;

    protected $fillable = [
        'nama_peminjam',
        'jk',
        'alamat',
        'no_telpon',
        'email',
        'password',
        'status',
        'foto',
        'nip',
        'nuptk',
        'nik',
        'nisn',
        'kelas',
        'tahun_ajaran',
    ];

    protected $hidden = [
        'password',
    ];
}
