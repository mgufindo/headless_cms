<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeCategoriesToUuid extends Migration
{
    public function up()
    {
        // Hapus foreign key constraints terlebih dahulu
        Schema::table('post_category', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        // Ubah kolom id menjadi uuid
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->uuid('id')->primary()->first();
        });

        // Update post_category untuk referensi uuid
        Schema::table('post_category', function (Blueprint $table) {
            $table->uuid('category_id')->change();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Tidak disarankan untuk rollback
    }
}
