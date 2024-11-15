<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->string('photo')->nullable(); // Kolom untuk menyimpan nama file foto bukti transfer
        });
    }

    public function down()
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }

};
