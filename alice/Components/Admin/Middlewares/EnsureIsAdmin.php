<?php

namespace Alice\Components\Admin\Middlewares;

use Alice\Context;
use Alice\Contracts\Middleware;
use Closure;

class EnsureIsAdmin implements Middleware
{
    public function handle(Context $context, Closure $next)
    {
        if (!$context->session()->get('$admin', false)) {
            return reply('Пожалуйста, авторизуйтесь.');
        }

        $next($context);
    }
}
