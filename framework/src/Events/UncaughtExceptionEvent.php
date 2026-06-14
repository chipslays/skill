<?php

namespace Framework\Events;

use Alice\Context;
use Throwable;

class UncaughtExceptionEvent
{
    public function __invoke(?Context $context, Throwable $th)
    {
        $dir = storage_path('logs/exceptions/' . date('Y-m-d'));

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $file = $dir . '/exceptions.log';

        if (file_exists($file) && filesize($file) > 1e+7) {
            $timestamp = date('H_i_s');
            rename($file, $dir . "/exceptions-{$timestamp}.log");
        }

        $date = date('d.m.Y H:i:s');

        file_put_contents($file, "[$date] [context] -> " . $context . "\n[exception] -> " . $th . "\n\n" . str_repeat('-', 64) . "\n\n", FILE_APPEND);
    }
}
