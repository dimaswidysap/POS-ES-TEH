<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $produk = [
            // Es Teh Original
            [
                'nama_produk' => 'Es Teh Original Reguler',
                'harga_produk' => 5000,
                'deskripsi' => 'Es teh manis original ukuran reguler, segar dan nikmat.',
            ],
            [
                'nama_produk' => 'Es Teh Original Jumbo',
                'harga_produk' => 8000,
                'deskripsi' => 'Es teh manis original ukuran jumbo, lebih banyak lebih segar.',
            ],

            // Es Teh Lemon
            [
                'nama_produk' => 'Es Teh Lemon Reguler',
                'harga_produk' => 6000,
                'deskripsi' => 'Es teh dengan perasan lemon segar ukuran reguler.',
            ],
            [
                'nama_produk' => 'Es Teh Lemon Jumbo',
                'harga_produk' => 9000,
                'deskripsi' => 'Es teh dengan perasan lemon segar ukuran jumbo.',
            ],

            // Es Teh Markisa
            [
                'nama_produk' => 'Es Teh Markisa Reguler',
                'harga_produk' => 6000,
                'deskripsi' => 'Es teh dengan rasa markisa manis asam ukuran reguler.',
            ],
            [
                'nama_produk' => 'Es Teh Markisa Jumbo',
                'harga_produk' => 9000,
                'deskripsi' => 'Es teh dengan rasa markisa manis asam ukuran jumbo.',
            ],

            // Es Teh Stroberi
            [
                'nama_produk' => 'Es Teh Stroberi Reguler',
                'harga_produk' => 7000,
                'deskripsi' => 'Es teh dengan rasa stroberi yang manis dan menyegarkan ukuran reguler.',
            ],
            [
                'nama_produk' => 'Es Teh Stroberi Jumbo',
                'harga_produk' => 10000,
                'deskripsi' => 'Es teh dengan rasa stroberi yang manis dan menyegarkan ukuran jumbo.',
            ],

            // Es Teh Pandan
            [
                'nama_produk' => 'Es Teh Pandan Reguler',
                'harga_produk' => 6000,
                'deskripsi' => 'Es teh dengan aroma pandan wangi ukuran reguler.',
            ],
            [
                'nama_produk' => 'Es Teh Pandan Jumbo',
                'harga_produk' => 9000,
                'deskripsi' => 'Es teh dengan aroma pandan wangi ukuran jumbo.',
            ],

            // Es Coklat
            [
                'nama_produk' => 'Es Coklat Reguler',
                'harga_produk' => 8000,
                'deskripsi' => 'Minuman coklat dingin yang kaya dan creamy ukuran reguler.',
            ],
            [
                'nama_produk' => 'Es Coklat Jumbo',
                'harga_produk' => 12000,
                'deskripsi' => 'Minuman coklat dingin yang kaya dan creamy ukuran jumbo.',
            ],
        ];

        foreach ($produk as $item) {
            Produk::create($item);
        }
    }
}
