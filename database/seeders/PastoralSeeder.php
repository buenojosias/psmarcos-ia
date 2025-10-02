<?php

namespace Database\Seeders;

use App\Models\Pastoral;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PastoralSeeder extends Seeder
{
    public function run(): void
    {
        Pastoral::create([
            'community_id' => 1,
            'user_id' => 1,
            'name' => 'Coral Doce Canto',
            'slug' => 'coral_doce_canto',
            'description' => 'O Coral Doce Canto é um grupo musical formado por crianças e adolescentes que tem como objetivo animar as celebrações litúrgicas e promover a música sacra na comunidade.',
        ]);

        Pastoral::factory()->count(10)->create();
    }
}
