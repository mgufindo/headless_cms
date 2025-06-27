<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Assign all permissions to admin role
        $permissions = DB::table('permissions')->pluck('id');
        foreach ($permissions as $permissionId) {
            DB::table('role_permission')->insert([
                'role_id' => 1, // admin role
                'permission_id' => $permissionId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Assign basic permissions to editor role
        $editorPermissions = DB::table('permissions')
            ->whereIn('name', [
                'view_posts',
                'create_posts',
                'edit_posts',
                'view_pages',
                'create_pages',
                'edit_pages',
                'view_categories',
                'create_categories',
                'edit_categories',
                'view_users',
                'create_users',
                'edit_users',
                'delete_users',
            ])->pluck('id');

        foreach ($editorPermissions as $permissionId) {
            DB::table('role_permission')->insert([
                'role_id' => 2, // editor role
                'permission_id' => $permissionId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Assign limited permissions to author role
        $authorPermissions = DB::table('permissions')
            ->whereIn('name', [
                'view_posts',
                'create_posts',
                'edit_posts',
                'view_categories'
            ])->pluck('id');

        foreach ($authorPermissions as $permissionId) {
            DB::table('role_permission')->insert([
                'role_id' => 3, // author role
                'permission_id' => $permissionId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('role_permission');
    }
};
