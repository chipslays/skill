<?php

use Alice\Alice;

require __DIR__ . '/../vendor/autoload.php';

/** @var Alice $alice */
$alice = require_once __DIR__ . '/../bootstap/alice.php';

$alice->dispatch();
