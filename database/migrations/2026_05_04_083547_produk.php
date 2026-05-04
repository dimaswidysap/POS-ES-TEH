<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->char('id_produk', 6)->primary();
            $table->string('nama_produk');
            $table->decimal('harga_produk', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->timestamps(); // membuat created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
