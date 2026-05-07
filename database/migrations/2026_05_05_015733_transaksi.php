<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->decimal('total_harga', 12, 2);
            $table->decimal('uang_pelanggan', 12, 2);
            $table->decimal('kembalian', 12, 2);
            $table->timestamp('tanggal_transaksi')->useCurrent();
            $table->timestamps();
        });

        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id('id_detail_transaksi');
            $table->unsignedBigInteger('id_transaksi');
            $table->unsignedBigInteger('id_produk');
            $table->integer('quantity');
            $table->decimal('harga_satuan', 10, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            // Relasi ke transaksi
            $table->foreign('id_transaksi')
                ->references('id_transaksi')
                ->on('transaksi')
                ->onDelete('cascade');

            // Relasi ke produk
            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produk')
                ->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Urutan drop harus terbalik karena ada foreign key
        Schema::dropIfExists('detail_transaksi');
        Schema::dropIfExists('transaksi');
    }
};
