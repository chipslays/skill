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
