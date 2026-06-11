<?php

namespace Alice\Components\WhatVersion;

use Alice\Alice;
use Alice\Component as BaseComponent;
use Alice\Context;
use Alice\Settings;

class Component extends BaseComponent
{
    public function register(Alice $alice, Context $context, Settings $settings): void
    {
        $alice->onCommand('версия', function () use ($alice) {
            $version = $this->data->get('version', 'неизвестна');
            $alice->reply("Текущая версия навыка: {$version}");
        });
    }
}
