<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\House;
use Faker\Generator as Faker;

$factory->define(House::class, function (Faker $faker) {
    return [
        'name'     => $faker->name,
        'price'    => $faker->numberBetween(150000),
        'bedroom'  => $faker->numberBetween(0, 5),
        'bathroom' => $faker->numberBetween(0, 5),
        'storey'   => $faker->numberBetween(0, 5),
        'garage'   => $faker->numberBetween(0, 5),
    ];
});
