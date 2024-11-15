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
            $table->timestamp('verified_at')->nullable()->after('rejected_at');
        });
    }
    
    public function down()
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->dropColumn('verified_at');
        });
    }
    
};
