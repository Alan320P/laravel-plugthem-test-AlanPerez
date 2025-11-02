<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Survey;
use App\Models\User;

class SurveySeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            Survey::create([
                'title' => 'Encuesta de prueba de ' . $user->name,
                'description' => 'Descripción de prueba',
                'status' => 'active',
                'user_id' => $user->id,
            ]);
        }
    }
}
