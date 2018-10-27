<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


/////////////////// User Factory //////////////////////
$factory->define(App\User::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10)
    ];
});

///////////////// Channel Factory ///////////////////////
$factory->define(App\Channel::class, function (Faker $faker) {
	$word = $faker->word ;
    return [
        'name' => $word,
        'slug' => $word
    ];
});

//////////////// Thread Factory ///////////////////////////
$factory->define(App\Thread::class, function (Faker $faker) {
    $sentence = $faker->sentence ;

    return [
        'title' => $sentence,
        'slug' => str_slug($sentence),
        'body' => $faker->paragraph . " " . $faker->paragraph,
        'user_id' => function(){return factory(App\User::class)->create()->id;},
        'channel_id' => function(){return factory(App\Channel::class)->create()->id;}
    ];
});


//////////////// Comment Factory ///////////////////////////
$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph,
        'user_id' => function(){return factory(App\User::class)->create()->id;},
        'thread_id' => function(){return factory(App\Thread::class)->create()->id;}
    ];
});

//////////////// Like Factory ///////////////////////////
$factory->define(App\Like::class, function (Faker $faker) {
    return [
        'user_id' => function(){return factory(App\User::class)->create()->id;},
        'likable_id' => function(){return factory(App\Comment::class)->create()->id;},
        'likable_type' => 'App\Comment'
    ];
});
