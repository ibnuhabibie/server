<?php

use App\DynamoDbShare;
use App\Share;
use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;

$factory->define(Share::class, function (Faker $faker) {
    return [
        'data' => [
            'key' => 'value'
        ],
        'selection' => '',
        'token' => Str::random(24),
        'ip' => $faker->ipv4
    ];
});

$factory->define(DynamoDbShare::class, function (Faker $faker) {
    return [
        'id' => Uuid::uuid4()->toString(),
        'data' => [
            'key' => 'value'
        ],
        'selection' => '',
        'token' => Str::random(24),
        'ip' => $faker->ipv4
    ];
});

