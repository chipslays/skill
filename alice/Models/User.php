<?php

namespace Alice\Models;

use Framework\Database\Models\User as BaseUser;

class User extends BaseUser
{
    protected $fillable = [
        'user_id',
        'application_id',
    ];
}
