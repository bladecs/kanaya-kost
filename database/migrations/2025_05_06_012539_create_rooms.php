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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id(); // id() sudah otomatis primary key, tidak perlu ->primary()
            $table->string('nama');
            $table->decimal('price', 10, 2); // Lebih tepat untuk harga
            $table->string('lantai');
            $table->text('description'); // Gunakan text jika tidak perlu sangat panjang
            $table->boolean('available')->default(true); // Default true
            $table->decimal('rating', 3, 1)->nullable(); // Format decimal untuk rating (contoh: 4.5)
            $table->string('tenant')->nullable(); // Nama penyewa, jika ada
            $table->timestamps();

            // Untuk unique constraint, lebih baik dipisah seperti ini
            $table->unique('nama');
        });

        // Buat tabel facilities jika belum ada
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Buat tabel pivot facility_room
        Schema::create('facility_room', function (Blueprint $table) {
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('facility_id')->constrained()->onDelete('cascade');
            $table->primary(['room_id', 'facility_id']); // Composite primary key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus tabel pivot terlebih dahulu
        Schema::dropIfExists('facility_room');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('facilities');
    }
};