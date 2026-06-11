<?php

namespace Alice\Events\Skill;

use Alice\Alice;
use Alice\Support\Container;

class StartEvent
{
    public function __invoke(): void
    {
        $alice = Container::getInstance()->get(Alice::class);
        $alice->reply('Как говорится, привет мир!');
    }
}
