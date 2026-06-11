<?php

namespace Framework\Database\Migration;

use Alice\Alice;
use Illuminate\Database\Capsule\Manager as Capsule;

class Manager
{
    public static function up(): void
    {
        /** @var Alice $alice */
        $alice = require_once project_path('bootstap/alice.php');

        foreach (glob(database_path('migrations/*.php')) as $file) {
            $migration = require $file;
            $migration->up(Capsule::schema());

            echo basename($file) . ' ...... up' .  PHP_EOL;
        }
    }

    public static function down(): void
    {
        /** @var Alice $alice */
        $alice = require_once project_path('bootstap/alice.php');

        foreach (array_reverse(glob(database_path('migrations/*.php'))) as $file) {
            $migration = require $file;
            $migration->down(Capsule::schema());

            echo basename($file) . ' ...... down' .  PHP_EOL;
        }
    }

    public static function fresh(): void
    {
        self::down();
        self::up();
    }
}
