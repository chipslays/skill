<?php

namespace Framework;

use Alice\Alice;
use Alice\Settings;
use Alice\Support\Container;
use Dotenv\Dotenv;
use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher as IlluminateEventDispatcher;

class Bootstrap
{
    protected array $settings = [];

    protected string $userModel;

    protected Alice $alice;

    public function withEnv(string $path): static
    {
        Dotenv::createImmutable($path)->load();

        return $this;
    }

    public function withSettings(string $path): static
    {
        $path = rtrim($path, '\/');

        foreach (glob($path . '/*.php') as $file) {
            $key = basename($file, '.php');
            $value = $key === 'alice' ? require $file : [$key => require $file];
            $this->settings = array_merge($this->settings, $value);
        }

        date_default_timezone_set($this->settings['timezone']);

        return $this;
    }

    public function withEvents(string $path): static
    {
        $path = rtrim($path, '\/');

        foreach (glob($path . '/**/*.php') as $file) {
            require $file;
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
        $settings = new Settings($this->settings);

        $this->alice = new Alice($settings);

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
