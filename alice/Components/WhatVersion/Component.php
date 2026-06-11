<?php

namespace Alice\Components\WhatVersion;

use Alice\Alice;

class Component
{
    public function register(Alice $alice)
    {
        $alice->onCommand('версия', function () use ($alice) {
            $version = $this->get('version', 'неизвестна');
            $alice->reply("Текущая версия навыка: {$version}");
        });
    }
}
