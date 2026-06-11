<?php

use Alice\Models\User;
use Framework\Bootstrap;

return new Bootstrap(project_path('settings'))
    ->withEnv(project_path())
    ->withEvents(project_path('events'))
    ->useUserModel(User::class)
    ->boot();
