<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['C', 'P', 'E', 'G']);
            $table->string('content');
            $table->integer('usages')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};
