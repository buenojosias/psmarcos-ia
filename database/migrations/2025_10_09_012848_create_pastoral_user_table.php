<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pastoral_user', function (Blueprint $table) {
            $table->foreignId('pastoral_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_leader')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pastoral_user');
    }
};
