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
        Schema::create('raise_funds', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('links');
            $table->string('pictures');
            $table->string('funds');
            $table->date('closed_funds');
            $table->string('details_funds');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('receiver_id')->constrained('receivers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raise_funds');
    }
};
