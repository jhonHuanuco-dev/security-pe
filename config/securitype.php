<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SecurityPe Connections Database
    |--------------------------------------------------------------------------
    |
    | Set the default configuration for running migrations, these must 
    | be registered in your config/database.php file.
    |
    */

    'connection' => 'default',

    /*
    |--------------------------------------------------------------------------
    | SecurityPe Models
    |--------------------------------------------------------------------------
    | 
    | This section of the configuration defines mappings for different 
    | models in the application and migrations. Each model is associated 
    | to a database table with its respective schema. To work correctly 
    | you must have previously created your schema in your database or 
    | set up a database user with high privileges in your .env file.
    |
    */

    'models' => [

        'activity' => [

            'name' => 'security.activity',
            
        ],

        'branches' => [

            'name' => 'security.branches',

        ],

        'users' => [

            'name' => 'security.users',

        ],

        'personal_access_tokens' => [

            'name' => 'security.personal_access_tokens',

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | SecurityPe Proxy
    |--------------------------------------------------------------------------
    |
    | This option is useful for projects implemented on localhost as it 
    | helps to capture the local IP of the machine where the user is 
    | connecting from.
    | 
    | If the internal network has a proxy the captured IP will be the same 
    | for everyone so you must enable the HTTP_X_FORWARDED_FOR option to 
    | capture the unique IP of each user.
    | 
    | These options are used in the authentication system to identify 
    | the user and the origin from where the user is logging in. It 
    | also prevents multiple users logging in with the same user 
    | on different computers.
    |
    */

    'proxy' => [

        'enable' => false,

        'servers' => ['127.0.0.1'],

        'forwarded_for_on' => false,

    ],

    /*
    |--------------------------------------------------------------------------
    | SecurityPe Session
    |--------------------------------------------------------------------------
    |
    | This option is used to manage certain session token settings, 
    | such as name and expiration time.
    | 
    | Remember that in every request to the server you must send the 
    | session token in order to access the server's resources.
    |
    */

    'session' => [

        'name' => 'securitype_session',

        'expired' => now()->addHours(8),

    ],

    /*
    |--------------------------------------------------------------------------
    | SecurityPe Routes
    |--------------------------------------------------------------------------
    |
    | Enables/Disables SecurityPe default paths. Disable this option 
    | if "only_bridge" is set to "true" unless required.
    | 
    | After changing this option you need to update the route cache. 
    | Run "php artisan route:clear" to clear and generate the 
    | application routes.
    |
    */

    'routes' => true,

    /*
    |--------------------------------------------------------------------------
    | SecurityPe Bridge
    |--------------------------------------------------------------------------
    | 
    | Enabling this option means that migrations are not executed in 
    | the current project and that it is only used as a bridge to another 
    | project that already has SecurityPe enabled. It is necessary that 
    | the "connection" option is linked to the database engine where 
    | SecurityPe is already enabled.
    | 
    | This option is useful for microservices architecture projects.
    |
    */

    'only_bridge' => false,
];
