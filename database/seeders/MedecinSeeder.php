<?php

namespace Database\Seeders;

use App\Models\Medecin;
use Illuminate\Database\Seeder;

class MedecinSeeder extends Seeder
{
    public function run(): void
    {
        Medecin::create([
            'nom'        => 'Chaabane',
            'prenom'     => 'Sami',
            'specialite' => 'Cardiologie',
            'telephone'  => '71234567',
            'email'      => 'sami.chaabane@medicare.com',
        ]);

        Medecin::create([
            'nom'        => 'Mansour',
            'prenom'     => 'Leila',
            'specialite' => 'Pédiatrie',
            'telephone'  => '71345678',
            'email'      => 'leila.mansour@medicare.com',
        ]);
    }
}
