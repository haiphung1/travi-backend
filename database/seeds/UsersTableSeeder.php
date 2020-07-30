<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Nguyễn Viết',
                'last_name' => 'Quang',
                'username' => 'quangvh',
                'email' => 'quangvhk123@gmail.com',
                'gender' => 1,
                'role_id' => 1,
                'birthdate' => '1996-03-06',
                'avatar' => 'https://static2.yan.vn/YanNews/2167221/201909/nhan-sac-hoi-hotgirl-viet-noi-tieng-mxh-trung-quoc-22da3c9c.jpg',
                'phone_number' => '0353690000',
                'password' => Hash::make('Quangvhk123')
            ]
        ]);
        factory(App\User::class, 3)->create();
    }
}
