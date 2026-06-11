<?php

use Alice\Models\User;
use Alice\Support\Container;

if (!function_exists('user')) {
    /**
     * @return User
     */
    function user(): User
    {
        return Container::getInstance()->get('user');
    }
}
