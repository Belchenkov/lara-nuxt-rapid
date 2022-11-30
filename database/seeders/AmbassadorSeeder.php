<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AmbassadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Belchenkov',
            'last_name' =>  'Aleksey',
            'email' => 'belchenkov.test@gmail.com',
            'is_admin' => 1,
            'password' => Hash::make('12qwasZX'),
        ]);

        User::factory(30)->create();
    }
}
