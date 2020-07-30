<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('permissions')->insert([
            [
                'key' => 'ROLE:CREATE',
                'description' => $faker->sentence(),
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'key' => 'PERMISSION:CREATE',
                'description' => $faker->sentence(),
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'key' => 'PERMISSION:ASSIGN',
                'description' => $faker->sentence(),
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'key' => 'TRAVEL_GROUP:CREATE',
                'description' => $faker->sentence(),
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'key' => 'ROLE:ASSIGN',
                'description' => $faker->sentence(),
                'created_by' => 1,
                'updated_by' => 1,
            ]
        ]);
    }
}
