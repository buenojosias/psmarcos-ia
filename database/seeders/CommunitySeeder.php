<?php

namespace Database\Seeders;

use App\Models\Community;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    public function run(): void
    {
        $communities = [
            [
                'name' => 'Matriz São Marcos',
                'alias' => 'Matriz',
                'address' => 'Rua Roberto Gava, 310',
            ],
            [
                'name' => 'Capela Beato Giacomo Cusmano',
                'alias' => 'Beato',
                'address' => 'Rua Victório Gabardo, 325 (Bracatinga/Primavera)',
            ],
            [
                'name' => 'Capela Nossa Senhora da Misericórdia',
                'alias' => 'Misericórdia',
                'address' => 'R. Campo Largo da Piedade, 462 (Vila Nori/Jardim Kosmos)',
            ],
            [
                'name' => 'Capela Nossa Senhora da Perseverança',
                'alias' => 'Perseverança',
                'address' => 'R. Alexandre Von Humboldt, 283 (Próximo à Cruz do Pilarzinho)',
            ],
            [
                'name' => 'Capela Nossa Senhora do Pilar',
                'alias' => 'Pilar',
                'address' => 'R. São Salvador, 420',
            ],
            [
                'name' => 'Capela São João Neumann',
                'alias' => 'São João',
                'address' => 'R. Ten. Miguel Anselmo da Silva, 485 (Vila dos Imigrantes)',
            ]
        ];

        Community::insert($communities);
    }
}
