<?php

return [

    /**
     * Идентификатор навыка.
     *
     * Используется при загрузке изображений и звуков.
     */
    'skill_id' => env('SKILL_ID', null),

    /**
     * OAuth-токен.
     *
     * Используется при загрузке изображений и звуков.
     */
    'oauth_token' => env('OAUTH_TOKEN', null),

    /**
     * Временная зона.
     */
    'timezone' => env('TIMEZONE', 'Europe/Samara'),

];
