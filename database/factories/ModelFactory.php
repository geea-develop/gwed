<?php

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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'rememberToken' => str_random(10),
    ];
});

$factory->define(App\Models\Wedding::class, function (Faker\Generator $faker) {
    return [
        'groomName' => $faker->name('male'),
        'brideName' => $faker->name('female'),
        'date' 		=> $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 year', $timezone = date_default_timezone_get()),
        'location' 	=> $faker->country . ', '. $faker->city,
        'budget'    => $faker->randomFloat(2, 10000, 200000),
        'guests'    => $faker->randomNumber(3)
    ];
});

$factory->define(App\Models\Vendor::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->company,
        'uname' => (string)$faker->unique()->unixTime,
        'phone' => $faker->phoneNumber,
        'email' => $faker->companyEmail,
        'cost'  => $faker->randomFloat(2, 0, 10000)
    ];
});

$factory->define(App\Models\Guest::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->name,
        'type'  => $faker->randomElement(getGuestTypes()),
        'side'  => $faker->randomElement(getPartners()),
        'phone' => $faker->phoneNumber,
        'email' => $faker->email
    ];
});

$factory->define(App\Models\Event::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->randomElement(getEventNames()),
        'description' => $faker->text(100),
        'date' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 year', $timezone = date_default_timezone_get())
    ];
});

$factory->define(App\Models\Profession::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->jobTitle,
        'uname' => (string)$faker->unique()->unixTime,
        'description' => $faker->text(100)
    ];
});

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'title'  => $faker->text(20),
        'uname' => (string)$faker->unique()->unixTime,
        'description' => $faker->text(100),
        'price' => $faker->randomFloat(200, 0, 999),
        'category'  => $faker->randomElement(['Decorations', 'Fashion', 'Cosmetics', 'Electronics', 'Accessories', 'Clothing']),
        'brand'  => $faker->randomElement(['Amazon', 'Adidas', 'Nivea', 'Gucci', 'Apple', 'Gillette', 'Hilton', 'Boss', 'Phillips', 'Pizza-Hut']),
        'image'     => $faker->imageUrl(),
        'logo'      => $faker->imageUrl(150, 150)
    ];
});
