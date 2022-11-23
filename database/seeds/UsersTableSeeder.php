<?php

use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::updateOrCreate(
            [
                'name' => 'Admin',
                'email' => 'admin@appointment.test'
            ],
            [
                'password' => bcrypt('test')
            ]
        );
    }
}
