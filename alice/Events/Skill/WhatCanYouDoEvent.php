<?php

namespace Alice\Events\Skill;

use Alice\Alice;

class WhatCanYouDoEvent
{
    public function __invoke(Alice $alice): void
    {
        $alice->reply('Я умею много всего, например, {кто-нибудь заполните это}');
    }
}
