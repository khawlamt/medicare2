<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        Patient::create([
            'nom' => 'Ben Ali',
            'prenom' => 'Mohamed',
            'date_naissance' => '1985-03-15',
            'sexe' => 'M',
            'telephone' => '22334455',
            'email' => 'mohamed@example.com',
            'groupe_sanguin' => 'A+',
            'antecedents' => 'Diabète type 2',
        ]);

        Patient::create([
            'nom' => 'Trabelsi',
            'prenom' => 'Fatma',
            'date_naissance' => '1992-07-22',
            'sexe' => 'F',
            'telephone' => '55667788',
            'email' => 'fatma@example.com',
            'groupe_sanguin' => 'O+',
            'antecedents' => 'Hypertension',
        ]);
    }
}
