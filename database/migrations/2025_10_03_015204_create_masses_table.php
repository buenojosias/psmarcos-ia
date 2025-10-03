<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('masses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('weekday');
            $table->time('time');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('masses');
    }
};
