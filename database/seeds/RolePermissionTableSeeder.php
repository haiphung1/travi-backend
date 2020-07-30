<?php

use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permission')->insert([
            [
                'role_id' => 1,
                'permission_id' => 1,
                'created_by' => 1
            ],
            [
                'role_id' => 1,
                'permission_id' => 2,
                'created_by' => 1
            ],
            [
                'role_id' => 1,
                'permission_id' => 3,
                'created_by' => 1
            ],
            [
                'role_id' => 1,
                'permission_id' => 4,
                'created_by' => 1
            ],
            [
                'role_id' => 1,
                'permission_id' => 5,
                'created_by' => 1
            ],
            [
                'role_id' => 2,
                'permission_id' => 5,
                'created_by' => 1
            ],
        ]);
    }
}
