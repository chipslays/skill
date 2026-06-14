<?php

use Alice\Alice;
use Alice\Events\Skill\DangerousEvent;
use Alice\Events\Skill\ErrorEvent;
use Alice\Events\Skill\FallbackEvent;
use Alice\Events\Skill\HelpEvent;
use Alice\Events\Skill\PurchaseConfirmationEvent;
use Alice\Events\Skill\ShowPullEvent;
use Alice\Events\Skill\StartEvent;
use Alice\Events\Skill\WhatCanYouDoEvent;

/** @var Alice $alice */

$alice->onStart(StartEvent::class);
$alice->onWhatCanYouDo(WhatCanYouDoEvent::class);
$alice->onHelp(HelpEvent::class);
$alice->onFallback(FallbackEvent::class);
$alice->onDangerous(DangerousEvent::class);
$alice->onError(ErrorEvent::class);
$alice->onPurchaseConfirmation(PurchaseConfirmationEvent::class);
$alice->onShowPull(ShowPullEvent::class);
