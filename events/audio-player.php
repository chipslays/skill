<?php

use Alice\Alice;
use Alice\Events\AudioPlayer\PlaybackFailedEvent;
use Alice\Events\AudioPlayer\PlaybackFinishedEvent;
use Alice\Events\AudioPlayer\PlaybackNearlyFinishedEvent;
use Alice\Events\AudioPlayer\PlaybackStartedEvent;
use Alice\Events\AudioPlayer\PlaybackStoppedEvent;

/** @var Alice $alice */

$alice->onAudioPlayerPlaybackFailed(PlaybackFailedEvent::class);
$alice->onAudioPlayerPlaybackFinished(PlaybackFinishedEvent::class);
$alice->onAudioPlayerPlaybackNearlyFinished(PlaybackNearlyFinishedEvent::class);
$alice->onAudioPlayerPlaybackStarted(PlaybackStartedEvent::class);
$alice->onAudioPlayerPlaybackStopped(PlaybackStoppedEvent::class);
