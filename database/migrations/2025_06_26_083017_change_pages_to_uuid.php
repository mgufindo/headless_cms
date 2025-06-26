<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {

        // Ubah kolom id menjadi uuid
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('id'); // Hapus kolom id yang lama
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->uuid('id')->primary()->first();
        });
    }

    public function down()
    {
        // Tidak disarankan untuk rollback karena akan kehilangan data
    }
};
