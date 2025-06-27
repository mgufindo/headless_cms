<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Assign admin role to first user
        if (DB::table('users')->exists()) {
            DB::table('user_role')->insert([
                'user_id' => DB::table('users')->first()->id,
                'role_id' => 1, // admin role
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('user_role');
    }
};
