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
        Schema::table('pages', function (Blueprint $table) {
            // Ubah ke tipe boolean atau tinyInteger
            $table->boolean('status')->default(0)->change();

            // Atau jika menggunakan tinyInteger:
            // $table->tinyInteger('status')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            // Kembalikan ke enum jika rollback
            $table->enum('status', ['draft', 'published'])->default('draft')->change();
        });
    }
};
