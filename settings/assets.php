<?php

/**
 * Избражения и звуки.
 *
 * Позвляет задать алиасы для ассетов (изображений и звуков),
 * чтобы легко получить к ним доступ в навыке.
 *
 * Пример: $sound = Asset::get('game-win-1');
 * Пример: $ctx->reply('{asset:win-1} Победа!');
 */
return [
    'win-1' => 'alice-sounds-game-win-1.opus',
    'win-2' => 'alice-sounds-game-win-2.opus',
    'win-3' => 'alice-sounds-game-win-3.opus',
];
