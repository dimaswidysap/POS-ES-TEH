<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    protected $table = 'produk';

    protected $primaryKey = 'id_produk';
    // $table->id() = auto increment bigint, jadi biarkan default Laravel
    // public $incrementing = true  ← sudah default, tidak perlu ditulis
    // protected $keyType = 'int'   ← sudah default, tidak perlu ditulis

    protected $fillable = [
        'nama_produk',
        'harga_produk',
        'foto_produk',
        'deskripsi',
    ];

    public function detailTransaksi(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_produk', 'id_produk');
    }
}
