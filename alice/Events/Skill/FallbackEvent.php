<?php

namespace Alice\Events\Skill;

use Alice\Alice;

class FallbackEvent
{
    public function __invoke(Alice $alice): void
    {
        $alice->reply('Ой, я не понимаю.');
    }
}
