<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->morphs('questionable');
            $table->foreignId('suggestion_id')->nullable()->constrained()->nullOnDelete();
            $table->string('question');
            $table->string('answer')->nullable();
            $table->enum('status', ['pending', 'processed', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
