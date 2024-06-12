<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->text('password');
            $table->string('profile',255);
            $table->string('type',1);
            $table->string('phone',20);
            $table->string('address',255);
            $table->date('dob');
            $table->integer('create_user_id');
            $table->integer('update_user_id');
            $table->integer('delete_user_id');
            $table->datetime('create_at');
            $table->datetime('update_at');
            $table->datetime('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
