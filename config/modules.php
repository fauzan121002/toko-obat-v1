<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Path to Modules
    |--------------------------------------------------------------------------
    |
    | Define the path where you'd like to store your modules. Note that if you
    | choose a path that's outside of your public directory, you will need to
    | copy your module assets (CSS, images, etc.) to your public directory.
    |
     */

    'path' => base_path('modules'),

    /*
    |--------------------------------------------------------------------------
    | Modules Default State
    |--------------------------------------------------------------------------
    |
    | When a previously unknown module is added, if it doesn't have an 'enabled'
    | state set then this is the value which it will default to. If this is
    | not provided then the module will default to being 'enabled'.
    |
     */

    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Modules Base Namespace
    |--------------------------------------------------------------------------
    |
    | Define the base namespace for your modules. Be sure to update this value
    | if you move your modules directory to a new path. This is primarily used
    | by the module:make Artisan command.
    |
     */

    'namespace' => 'Smartpharmacy\Modules\\',

    /*
    |--------------------------------------------------------------------------
    | Default Module Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the module storage driver that will be utilized.
    | This driver manages the retrieval and management of module properties.
    | Setting this to custom allows you to specify your own driver instance.
    |
    | Supported: "local"
    |
     */

    'driver' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Remap Module Subdirectories
    |--------------------------------------------------------------------------
    |
    | Redefine how module directories are structured. The mapping here will
    | be respected by all commands and generators.
    |
     */

    'pathMap' => [
        'Database/Migrations' => 'database/migrations',
        'Database/Factories' => 'database/factories',
        'Database/Seeds' => 'database/seeds',
        'Models' => 'src/Models',
        'Http' => 'src/Http',
        'Policies' => 'src/Policies',
        'Providers' => 'src/Providers',
        'Resources/Views' => 'resources/views',
        'Resources/Lang' => 'resources/lang',
        'Routes' => 'routes',
    ],
];
