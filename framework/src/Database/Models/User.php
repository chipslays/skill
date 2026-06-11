<?php

namespace Framework\Database\Models;

use Alice\Context;
use Alice\Support\Container;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'user_id',
        'application_id',
    ];

    public static function createOrFirst(): static
    {
        $context = Container::getInstance()->get(Context::class);

        return once(function () use ($context) {
            return static::query()->createOrFirst([
                'user_id' => $context->get('session.user.user_id'),
                'application_id' => $context->get('session.application.application_id'),
            ]);
        });
    }
}
