<?php

if (!function_exists('project_path')) {
    /**
     * @param string $path
     * @return string
     */
    function project_path(string $path = ''): string
    {
        return rtrim(__DIR__ . '/../' . $path, '\/');
    }
}

if (!function_exists('storage_path')) {
    /**
     * @param string $path
     * @return string
     */
    function storage_path(string $path = ''): string
    {
        return rtrim(project_path('storage/' . $path), '\/');
    }
}

if (!function_exists('database_path')) {
    /**
     * @param string $path
     * @return string
     */
    function database_path(string $path = ''): string
    {
        return rtrim(project_path('database/' . $path), '\/');
    }
}

if (!function_exists('makeScaffold')) {
    /**
     * Создаёт новый файл на основе шаблона (stub).
     *
     * @param string $stubFile Относительный путь к шаблону (от корня проекта).
     * @param string $basePath Относительный путь к целевой директории (от корня проекта).
     * @param string $fullName Введённое пользователем имя, например "Auth/Login" или "LoginEvent".
     * @param string $entityName Отображаемое название сущности для сообщений ("компонент", "событие", …).
     * @param string $fileName Имя файла без расширения, например "Component" или имя класса.
     * @param bool $fullNameIsDir Если true, всё имя $fullName считается поддиректорией
     *                            (паттерн компонента: make:component Foo -> alice/Components/Foo/Component.php).
     *                            Если false (по умолчанию), последний сегмент — это имя класса/файла.
     * @param array $extra Дополнительные замены в шаблоне помимо %classname% / %namespace%.
     */
    function makeScaffold(
        string $stubFile,
        string $basePath,
        string $fullName,
        string $entityName,
        string $fileName,
        bool $fullNameIsDir = false,
        array $extra = []
    ): void {
        $segments = explode('/', str_replace('\\', '/', $fullName));
        $className = $fullNameIsDir ? $fileName : end($segments);
        $subDir = $fullNameIsDir
            ? implode('/', $segments)
            : implode('/', array_slice($segments, 0, -1));
        $namespace = $subDir ? '\\' . str_replace('/', '\\', $subDir) : '';

        $targetDir = rtrim(project_path($basePath . '/' . $subDir), '/');
        $targetDir = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $targetDir);

        $path = $targetDir . DIRECTORY_SEPARATOR . $fileName . '.php';

        if (file_exists($path)) {
            die("[!] {$entityName} уже существует: {$path}");
        }

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $stubPath = project_path($stubFile);
        $stub = file_get_contents($stubPath);

        if ($stub === false) {
            die("[!] Файл шаблона не найден: {$stubFile}");
        }

        $replacements = array_merge(
            ['%classname%' => $className, '%namespace%' => $namespace],
            $extra
        );

        $stub = str_replace(array_keys($replacements), array_values($replacements), $stub);

        $stub = preg_replace('/\\\\{2,}/', '\\\\', $stub);

        file_put_contents($path, $stub);

        $normalizedPath = str_replace(DIRECTORY_SEPARATOR, '/', $path);

        echo "[OK] {$entityName} создан: {$normalizedPath}";
    }
}

if (!function_exists('debug_log')) {
    /**
     * Запись отладочных сообщений в лог-файл.
     *
     * @param mixed ...$messages Любое количество сообщений (строки, массивы, объекты, исключения)
     * @return void
     */
    function debug_log(...$messages): void
    {
        // Определяем путь к лог-файлу
        $logDir = storage_path('logs');
        $logFile = $logDir . '/debug.log';

        // Создаём директорию, если её нет
        if (!is_dir($logDir)) {
            if (!mkdir($logDir, 0775, true) && !is_dir($logDir)) {
                error_log("Невозможно создать директорию для логов: {$logDir}");
                return;
            }
        }

        // Форматируем каждое сообщение
        $formattedMessages = array_map(function ($msg) {
            if (is_string($msg)) {
                return $msg;
            }
            if (is_array($msg) || is_object($msg)) {
                return print_r($msg, true);
            }
            if ($msg instanceof Throwable) {
                return $msg->getMessage() . "\n" . $msg->getTraceAsString();
            }
            return var_export($msg, true);
        }, $messages);

        // Собираем итоговую строку с временной меткой и уровнем
        $timestamp = date('Y-m-d H:i:s');
        $entry = "[{$timestamp}] " . implode("\n", $formattedMessages) . "\n";

        // Атомарная запись (флаг LOCK_EX для конкурентного доступа)
        file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);
    }
}
