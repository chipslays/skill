<?php

namespace Alice\Components\Admin;

use Alice\Alice;
use Alice\Component as BaseComponent;
use Alice\Components\Admin\Events\AuthEvent;
use Alice\Components\Admin\Events\UsersCountEvent;
use Alice\Components\Admin\Middlewares\EnsureIsAdmin;
use Alice\Context;
use Alice\Events\Group;
use Alice\Models\User;
use Alice\Settings;
use Alice\State\Session;
use Carbon\Carbon;

class Component extends BaseComponent
{
    public function register(Alice $alice, Context $context, Settings $settings): void
    {
        $settings->set('middlewares.aliases.admin', EnsureIsAdmin::class);

        $alice->onOriginalUtterance('!admin {password}', [AuthEvent::class, 'auth']);

        $alice->group(function(Alice $alice) {
            $alice->onOriginalUtterance('!logout', [AuthEvent::class, 'logout']);
            $alice->onOriginalUtterance('!users count {from?} {to?}', [UsersCountEvent::class]);
        })->middleware('admin');
    }
}
