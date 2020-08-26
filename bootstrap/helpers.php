<?php

if(!function_exists('scan_directory'))
{
    /**
     * scan directory & return only files
     *
     * @param string $path
     * @return void
     */
    function scan_directory(string $path)
    {
        return \collect(scandir($path))->filter(function($elem){ 
            if($elem != '.' && $elem !=='..') return $elem;
        })->values()->toArray();
    }
}

if(!function_exists('load_module_config'))
{
    /**
     * load module config
     *
     * @return void
     */
    function load_module_config()
    {
        $modules_path = base_path('modules');
        $modules      = scan_directory($modules_path);

        $cfg = [];

        foreach($modules as $module)
        {
            $files_dir = $modules_path . '/' . $module . '/config/';

            $files     = scan_directory($files_dir);

            foreach($files as $file)
            {
                $cfg[strtolower($module)][str_replace('.php', NULL, $file)] = require_once $files_dir . $file;
                \Config::set($cfg);
            }
        }
    }
}

if(!function_exists('load_module_middleware'))
{
    /**
     * load module middlewares
     *
     * @return void
     */
    function load_module_middleware()
    {
        $modules_path   = base_path('modules');
        $modules        = scan_directory($modules_path);

        $midleware = [];

        foreach($modules as $module)
        {
            $middleware_path = $modules_path .'/'. $module . '/Http/Middleware/';

            $files     = scan_directory($middleware_path);

            foreach($files as $file)
            {
                $class = "Modules\\$module\Http\Middleware\\". str_replace('.php', null, ucfirst($file)) . "::class";
                // load all middlewares here
                app()->make(\Illuminate\Contracts\Http\Kernel::class)
                    ->pushMiddleware($class);
            }
        }
    }
}

if(!function_exists('modules_commands'))
{
    /**
     * load module commands
     *
     * @return void
     */
    function modules_commands()
    {
        $modules_path   = base_path('modules');
        $modules        = scan_directory($modules_path);

        $commands = [];

        foreach($modules as $module)
        {
            $commands[] = $modules_path .'/'. $module . '/Console/Commands';
        }

        return $commands;
    }
}

if(!function_exists('modules_commands_definitions'))
{
    /**
     * load module definitions
     *
     * @return void
     */
    function modules_commands_definitions()
    {
        $modules_path   = base_path('modules');
        $modules        = scan_directory($modules_path);

        $commands = [];

        foreach($modules as $module)
        {
            $commands[] = $modules_path .'/'. $module . '/routes/console.php';
        }

        return $commands;
    }
}