<?php

namespace Alice\Components\Admin\Events;

use Alice\Models\User;
use Carbon\Carbon;

class UsersCountEvent
{
    public function __invoke(?string $from, ?string $to)
    {
        $query = User::query();

        if ($from) {
            $fromDate = Carbon::createFromFormat('d.m.Y', $from)->startOfDay();
            $toDate = $to
                ? Carbon::createFromFormat('d.m.Y', $to)->endOfDay()
                : Carbon::now()->endOfDay();

            $query->whereBetween('created_at', [$fromDate, $toDate]);
            $label = "с {$fromDate->format('d.m.Y')} по {$toDate->format('d.m.Y')}";
        } else {
            $label = 'за всё время';
        }

        reply("Всего пользователей ({$label}): {$query->count()}");
    }
}
