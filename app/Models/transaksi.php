<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $primaryKey = 'id_transaksi';
    // id_transaksi pakai $table->id() → auto increment, tidak perlu boot()

    protected $fillable = [
        'total_harga',
        'uang_pelanggan',
        'kembalian',
        'tanggal_transaksi',
    ];

    public function details()
    {
        return $this->hasMany(
            DetailTransaksi::class,
            'id_transaksi',
            'id_transaksi'
        );
    }
}
