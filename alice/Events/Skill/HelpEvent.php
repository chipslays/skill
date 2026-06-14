<?php

namespace Alice\Events\Skill;

use Alice\Alice;

class HelpEvent
{
    public function __invoke(Alice $alice): void
    {
        $alice->reply('Чем я могу вам помочь?');
    }
}
