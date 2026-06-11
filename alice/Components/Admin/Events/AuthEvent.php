<?php

namespace Alice\Components\Admin\Events;

use Alice\State\Session;

class AuthEvent
{
    public function auth(string $password, Session $session)
    {
        if (!env('ADMIN_PASSWORD', null)) {
            return reply('Упс, кажется вы забыли установить пароль в переменную ADMIN_PASSWORD.');
        }

        if ($password !== env('ADMIN_PASSWORD', null)) {
            return reply('Неверный пароль, попробуйте ещё раз 🚨');
        }

        $session->set('$admin', true);

        reply('Вы успешно авторизовались!');
    }

    public function logout(Session $session)
    {
        $session->remove('$admin');
        reply('Команды администратора больше не доступны.');
    }
}
