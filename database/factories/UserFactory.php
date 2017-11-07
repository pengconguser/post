<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
	static $password;
	$now = Carbon::now()->toDateTimeString();

	return [
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'password' => $password ?: $password = bcrypt('password'),
		'remember_token' => str_random(10),
		'introduction' => $faker->sentence(),
		'created_at' => $now,
		'updated_at' => $now,
	];
});