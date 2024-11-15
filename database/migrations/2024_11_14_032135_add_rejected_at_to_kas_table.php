<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRejectedAtToKasTable extends Migration
{
    /**
     * Menjalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->timestamp('rejected_at')->nullable();  // Menambahkan kolom rejected_at
        });
    }

    /**
     * Membatalkan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->dropColumn('rejected_at');  // Menghapus kolom rejected_at jika migrasi dibatalkan
        });
    }
}
