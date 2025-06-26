<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangePostsToUuid extends Migration
{
    public function up()
    {
        // Hapus foreign key constraints terlebih dahulu
        Schema::table('post_category', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
        });

        // Ubah kolom id menjadi uuid
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('id'); // Hapus kolom id yang lama
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->uuid('id')->primary()->first();
        });

        // Update post_category untuk referensi uuid
        Schema::table('post_category', function (Blueprint $table) {
            $table->uuid('post_id')->change();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Tidak disarankan untuk rollback karena akan kehilangan data
    }
}
