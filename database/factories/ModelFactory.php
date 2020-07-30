<?php
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'username' => $faker->userName,
        'email' => $faker->email,
        'gender' => $faker->numberBetween(1,0),
        'birthdate' => $faker->date(),
        'avatar' => $faker->imageUrl(),
        'phone_number' => $faker->phoneNumber,
        'password' => Hash::make('Quangvhk123')
    ];
});
$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    return [

            'image' => $faker->optional()->imageUrl(),
            'content' => $faker->lastName,
            'created_by' => $faker->numberBetween(1, 3),
            'type' => $faker->randomElement(['STATUS', 'REVIEW'])

    ];
});
