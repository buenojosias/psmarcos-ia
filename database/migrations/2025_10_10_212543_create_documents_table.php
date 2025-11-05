<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    protected $connection = 'pgsql';

    public function shouldRun(): bool
    {
        return false;
    }

    public function up(): void
    {
        // Garantir que a extensão pgvector está instalada
        DB::connection($this->connection)->statement('CREATE EXTENSION IF NOT EXISTS vector;');

        Schema::connection($this->connection)->create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Identificação e versionamento
            $table->string('resource')->nullable(); // Ex: comunidade, pastoral, missa, evento, aviso
            $table->string('name')->nullable(); // Nome da comunidade, pastoral ou evento
            $table->unsignedBigInteger('model_id')->nullable(); // ID do conteúdo no banco interno
            $table->string('doc_type', 50)->default('qa'); // Tipos: 'qa', 'description', 'notice'
            $table->integer('version')->default(1);

            // Conteúdo
            $table->text('question')->nullable();
            $table->text('answer')->nullable();
            $table->text('content'); // Conteúdo completo (sincronizado via trigger)

            // Metadados adicionais
            $table->jsonb('metadata')->nullable();

            $table->timestamps();

            // Índices básicos
            $table->index(['resource', 'model_id']);
            $table->index('doc_type');
            $table->index('created_at'); // Útil para ordenação por recência
        });

        // Adicionar coluna de embedding vetorial
        // IMPORTANTE: Dimensão 1536 é específica para text-embedding-ada-002 (OpenAI)
        // Se mudar o modelo de embedding no futuro, será necessário:
        // 1. Alterar a dimensão da coluna: ALTER TABLE documents ALTER COLUMN embedding TYPE vector(NOVA_DIMENSAO);
        // 2. Recriar TODOS os embeddings com o novo modelo
        // 3. Recriar o índice HNSW
        DB::connection($this->connection)->statement("
            ALTER TABLE documents ADD COLUMN embedding vector(1536);
        ");

        // Adicionar coluna tsvector para full-text search em português
        DB::connection($this->connection)->statement("
            ALTER TABLE documents ADD COLUMN tsv tsvector;
        ");

        // Constraint: garantir que campo 'content' seja sempre preenchido
        DB::connection($this->connection)->statement("
            ALTER TABLE documents ADD CONSTRAINT chk_content_not_empty
            CHECK (content IS NOT NULL AND content <> '');
        ");

        // ====================================================================
        // TRIGGERS
        // ====================================================================

        // Trigger: Manter tsvector atualizado para busca full-text
        // Executa apenas quando 'content' é modificado
        DB::connection($this->connection)->unprepared("
            CREATE OR REPLACE FUNCTION documents_tsv_trigger() RETURNS trigger AS $$
            BEGIN
                NEW.tsv := to_tsvector('portuguese', COALESCE(NEW.content, ''));
                RETURN NEW;
            END
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER trg_documents_tsv
            BEFORE INSERT OR UPDATE OF content ON documents
            FOR EACH ROW EXECUTE PROCEDURE documents_tsv_trigger();
        ");

        // ====================================================================
        // ÍNDICES DE PERFORMANCE
        // ====================================================================

        // Índice HNSW para busca por similaridade vetorial (cosine distance)
        // HNSW é mais rápido que IVFFlat e não precisa de treinamento
        // Parâmetros: m=16 (conexões por camada), ef_construction=64 (qualidade da construção)
        DB::connection($this->connection)->statement("
            CREATE INDEX idx_documents_embedding ON documents
            USING hnsw (embedding vector_cosine_ops)
            WITH (m = 16, ef_construction = 64);
        ");

        // Índice GIN para full-text search com tsvector
        DB::connection($this->connection)->statement("
            CREATE INDEX idx_documents_tsv ON documents USING GIN(tsv);
        ");

        // Índice composto para filtros comuns
        DB::connection($this->connection)->statement("
            CREATE INDEX idx_documents_resource_type ON documents (resource, doc_type);
        ");
    }

    public function down(): void
    {
        // Remover índices primeiro (o drop table já remove automaticamente, mas fica explícito)
        DB::connection($this->connection)->statement('DROP INDEX IF EXISTS idx_documents_embedding;');
        DB::connection($this->connection)->statement('DROP INDEX IF EXISTS idx_documents_tsv;');
        DB::connection($this->connection)->statement('DROP INDEX IF EXISTS idx_documents_resource_type;');

        // Remover triggers e functions
        DB::connection($this->connection)->unprepared('DROP TRIGGER IF EXISTS trg_documents_tsv ON documents;');
        DB::connection($this->connection)->unprepared('DROP FUNCTION IF EXISTS documents_tsv_trigger() CASCADE;');

        // Remover tabela
        Schema::connection($this->connection)->dropIfExists('documents');

        // Nota: Não removemos a extensão vector pois pode estar sendo usada por outras tabelas
        // Se precisar remover: DB::connection($this->connection)->statement('DROP EXTENSION IF EXISTS vector;');
    }
};
