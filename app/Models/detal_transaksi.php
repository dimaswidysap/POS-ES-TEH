<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'quantity',
        'harga_satuan',
        'subtotal',
    ];

    /**
     * Relasi many-to-one ke Transaksi
     * Banyak detail dimiliki satu transaksi
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    /**
     * Relasi many-to-one ke Produk
     * Banyak detail bisa merujuk ke satu produk
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
