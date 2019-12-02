<?php

namespace App;

use BaoPham\DynamoDb\DynamoDbModel;
use Ramsey\Uuid\Uuid;

class DynamoDbShare extends DynamoDbModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shares';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post)
        {
            $post->{$post->getKeyName()} = (string) Uuid::uuid4();
        });
    }
}
