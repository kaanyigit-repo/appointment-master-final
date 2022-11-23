<?php

use App\Client;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create(); //Activates fake data factory

        //the loop dictates which data should be present in new rows
        foreach (range(1, 20) as $value) {
            Client::create( //The statement creates a new row at the “clients” table
                [
                    'name' => $faker->name,
                    'phone' => $faker->phoneNumber,
                    'mail' => $faker->email,
                    'hourly_fee' => [100,50,150,200][array_rand([0,1,2,3])],
                    'other_info' => $faker->text
                ]
            );
        }
    }
}
