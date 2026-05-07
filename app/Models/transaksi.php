<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $primaryKey = 'id_transaksi';

    // ID tidak auto-increment (kita buat manual)

    protected $keyType = 'number';   // Tipe ID adalah string

    protected $fillable = [
        'id_transaksi',
        'total_harga',
        'uang_pelanggan',
        'kembalian',
        'tanggal_transaksi',
    ];

    /**
     * Relasi one-to-many ke DetailTransaksi
     * Satu transaksi bisa punya banyak detail
     */
    public function details(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }
}
