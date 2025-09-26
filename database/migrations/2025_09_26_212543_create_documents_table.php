<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected $connection = 'pgsql';

    public function up(): void
    {
        DB::connection($this->connection)->statement('CREATE EXTENSION IF NOT EXISTS vector;');

        Schema::connection($this->connection)->create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('resource');
            $table->string('name');
            $table->string('question_id');
            $table->text('question');
            $table->text('answer');
            $table->text('content');
            $table->jsonb('metadata')->default('{}');
            $table->integer('version')->default(1);
            $table->string('idempotency_key')->nullable();
            $table->unique(['question_id', 'name', 'resource'], 'docs_unique_qnr');
            $table->timestamps();
        });

        // adiciona a coluna embedding como vector via raw SQL
        DB::connection($this->connection)->statement("
            ALTER TABLE documents ADD COLUMN IF NOT EXISTS embedding vector(1536);
        ");

        // cria index vetorial (tentativa hnsw, senão ivfflat)
        try {
            DB::connection($this->connection)->statement("
                CREATE INDEX IF NOT EXISTS idx_documents_embedding_hnsw ON documents USING hnsw (embedding vector_cosine_ops);
            ");
        } catch (\Throwable $e) {
            DB::connection($this->connection)->statement("
                CREATE INDEX IF NOT EXISTS idx_documents_embedding_ivfflat ON documents USING ivfflat (embedding vector_cosine_ops) WITH (lists = 100);
            ");
        }
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('documents');
    }
};
