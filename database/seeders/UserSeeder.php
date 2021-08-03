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
        $user1 = new User();
        $user1->name="Michael";
        $user1->email="prueba1@prueba.com";
        $user1->password = Hash::make("password");
        $user1->assignRole(1);

        $user1->save();

        $user2 = new User();
        $user2->name="Siegal";
        $user2->email="prueba2@prueba.com";
        $user2->password = Hash::make("password");
        $user2->assignRole(2);

        $user2->save();
    }
}
