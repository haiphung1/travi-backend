<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'title' => 'SYSTEM_ADMIN',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'title' => 'CONTENT_ADMIN',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'title' => 'TOUR_GUIDE',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'title' => 'SERVICE_PROVIDER',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'title' => 'MEMBER',
                'created_by' => 1,
                'updated_by' => 1
            ],
        ]);
    }
}
