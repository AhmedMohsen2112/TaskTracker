<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Board;
use App\Models\BoardList;
use App\Models\BoardListIssue;
use Illuminate\Support\Str;
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

$factory->define(BoardListIssue::class, function (Faker $faker) {
    return [
        'title' => $faker->realText(rand(50,120)),
        'description' => $faker->realText(rand(120,180)),
        'ord'=>1,
        'list_id'=>factory_create(BoardList::class)->id
       
    ];
});
