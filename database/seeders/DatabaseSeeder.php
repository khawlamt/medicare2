<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Hospital::firstOrCreate(
            ['nom' => 'Hôpital La Rabta de Tunis'],
            [
                'ville' => 'Tunis',
                'gouvernorat' => 'Tunis',
                'adresse' => 'Rue Mongi Slim, La Rabta',
                'telephone' => '+216 71 123 456',
                'email' => 'larabta@example.tn',
                'latitude' => 36.8019444,
                'longitude' => 10.1544444,
                'type' => 'public',
                'urgence' => true,
                'maternite' => true,
                'chirurgie' => true,
                'description' => 'Hôpital public majeur de Tunis.',
            ]
        );
    }
}
