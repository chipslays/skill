<?php

namespace Framework;

use Alice\Alice;
use Alice\Settings;
use Alice\Support\Container;
use Dotenv\Dotenv;
use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher as IlluminateEventDispatcher;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class Bootstrap
{
    protected array $settings = [];

    protected string $userModel;

    protected Alice $alice;

    public function __construct(string $settingsPath)
    {
        $this->withSettings($settingsPath);

        $settings = new Settings($this->settings);

        $this->alice = new Alice($settings);
    }

    public function withEnv(string $path): static
    {
        Dotenv::createImmutable($path)->load();

        return $this;
    }

    protected function withSettings(string $path): static
    {
        $path = rtrim($path, '\/');

        $this->settings = array_merge($this->settings, $this->loadSettings($path, $path));

        date_default_timezone_set($this->settings['timezone']);

        return $this;
    }

    protected function loadSettings(string $basePath, string $currentPath): array
    {
        $result = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($currentPath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if (!$file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $relativePath = ltrim(str_replace($basePath, '', $file->getPath()), '\/');
            $key = $file->getBasename('.php');
            $value = require $file->getPathname();

            // alice.php в корне — merge напрямую
            if ($relativePath === '' && $key === 'alice') {
                $result = array_merge($result, $value);
                continue;
            }

            // Строим ключи из папок + имени файла
            $keys = $relativePath !== ''
                ? [...explode(DIRECTORY_SEPARATOR, $relativePath), $key]
                : [$key];

            $result = array_merge_recursive($result, $this->buildNested($keys, $value));
        }

        return $result;
    }

    protected function buildNested(array $keys, mixed $value): array
    {
        $result = [];
        $ref = &$result;

        foreach ($keys as $key) {
            $ref[$key] = [];
            $ref = &$ref[$key];
        }

        $ref = $value;

        return $result;
    }

    public function withEvents(string $path): static
    {
        $path = rtrim($path, '\/');

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        $phpFiles = new RegexIterator($iterator, '/\.php$/i');

        foreach ($phpFiles as $file) {
            (static function (Alice $alice) use ($file) {
                require_once $file->getPathname();
            })($this->alice);
        }

        return $this;
    }

    public function useUserModel(string $model): static
    {
        $this->userModel = $model;

        return $this;
    }

    public function boot(): Alice
    {
        $this->registerDatabase();
        $this->registerUser();

        return $this->alice;
    }

    protected function registerDatabase(): void
    {
        $connection = $this->settings['database']['connections'][$this->settings['database']['default']];

        if ($connection['driver'] === 'sqlite' && !file_exists($connection['database'])) {
            touch($connection['database']);
        }

        $capsule = new Capsule;
        $capsule->addConnection($connection);
        $capsule->setEventDispatcher(new IlluminateEventDispatcher(new IlluminateContainer));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    protected function registerUser(): void
    {
        if (!$this->alice->context) {
            return;
        }

        if (!Capsule::connection()->getPdo()) {
            return;
        }

        $schema = Capsule::schema();

        if (!$schema->hasTable('users')) {
            return;
        }

        $user = $this->userModel::createOrFirst();

        Container::getInstance()->instance('user', $user);
    }
}
