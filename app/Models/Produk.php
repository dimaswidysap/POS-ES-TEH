<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    protected $keyType = 'int';

    protected $fillable = [
        'nama_produk',
        'harga_produk',
        'deskripsi',
        'foto_produk',
    ];
}
