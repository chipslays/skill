<?php

use Alice\Models\User;
use Framework\Bootstrap;

return new Bootstrap()
    ->withEnv(project_path())
    ->withSettings(project_path('settings'))
    ->withEvents(project_path('events'))
    ->useUserModel(User::class)
    ->boot();
