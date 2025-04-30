<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up()
    {
        DB::table('admins')->insert([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        DB::table('admins')->where('email', 'admin@example.com')->delete();
    }
};