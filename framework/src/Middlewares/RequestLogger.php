<?php

namespace Framework\Middlewares;

use Alice\Context;
use Closure;

class RequestLogger
{
    public function __invoke(Context $context, Closure $next)
    {
        $next($context);

        $dir = storage_path('logs/requests/' . date('Y-m-d'));

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $file = $dir . '/requests.log';

        if (file_exists($file) && filesize($file) > 1e+7) {
            $timestamp = date('H_i_s');
            rename($file, $dir . "/requests-{$timestamp}.log");
        }

        $date = date('d.m.Y H:i:s');

        file_put_contents($file, "[$date] " . $context . "\n\n", FILE_APPEND | LOCK_EX);
    }
}
