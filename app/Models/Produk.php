<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_produk',
        'nama_produk',
        'harga_produk',
        'deskripsi',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_produk)) {
                do {
                    $id = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                } while (static::where('id_produk', $id)->exists());

                $model->id_produk = $id;
            }
        });
    }
}
