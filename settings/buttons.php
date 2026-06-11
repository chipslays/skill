<?php

/**
 * Переиспользуемые кнопки.
 *
 * Позвляет задать алисы для кнопок и переиспользовать их
 * в любом месте навыка.
 */

use Alice\Types\Button;

return [
    'confirm' => [
        Button::make('Да', 'YES'),
        Button::make('Нет', 'NO'),
    ],
];
