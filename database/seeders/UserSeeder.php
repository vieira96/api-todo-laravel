<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->createMany([
            [
                'email' => 'teste@hotmail.com',
                'password' => Hash::make('teste'),
            ],

            [
                'email' => 'teste@hotmail.com.br',
                'password' => Hash::make('teste'),
            ],

        ]);

    }
}
