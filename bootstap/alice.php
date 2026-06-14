<?php

use Alice\Models\User;
use Framework\Bootstrap;

return new Bootstrap()
    ->withEvents(project_path('events'))
    ->useUserModel(User::class)
    ->boot();
