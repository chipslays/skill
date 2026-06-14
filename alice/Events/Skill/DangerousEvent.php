<?php

namespace Alice\Events\Skill;

use Alice\Alice;

class DangerousEvent
{
    public function __invoke(Alice $alice): void
    {
        $alice->reply('Кажется, я не могу ответить на этот запрос.');
    }
}
