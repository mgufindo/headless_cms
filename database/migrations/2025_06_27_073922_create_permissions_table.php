<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default permissions
        $permissions = [
            'view_posts',
            'create_posts',
            'edit_posts',
            'delete_posts',
            'view_pages',
            'create_pages',
            'edit_pages',
            'delete_pages',
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',
            'manage_users',
            'manage_roles',
            'manage_permissions',
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'name' => $permission,
                'description' => ucfirst(str_replace('_', ' ', $permission)),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }
};
