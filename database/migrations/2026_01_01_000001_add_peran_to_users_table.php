<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom "nama" dan "peran" pada tabel users bawaan Laravel.
     * Kolom "name" bawaan tetap dibiarkan ada (tidak dipakai) supaya
     * migrasi bawaan Laravel tidak perlu diubah.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama')->after('id');
            $table->enum('peran', ['admin', 'user'])->default('user')->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nama', 'peran']);
        });
    }
};
