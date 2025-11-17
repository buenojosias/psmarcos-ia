<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $connection = 'pgsql';
    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Define a tabela baseada no ambiente
        $this->table = config('app.env') === 'local'
            ? 'documents_dev'
            : 'documents';
    }

    protected $guarded = [];
}
