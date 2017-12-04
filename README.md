## Laravel 4 Env Polyfill

Laravel 5 has a nice function `env()` which can assign a default variable if empty/null/blank. 

Laravel 4 applications are generally missing this functionality and if not running on >= `PHP 7.0` can't use the ?? notation 
to keep (isset($_ENV(thing))) ? $_ENV(thing) : default short and sweet e.g $_ENV(thing) ?? default.

## Installation

    `composer require zvps/laravel-4-env-polyfill`

## Setup

Make sure to start using the detectEnvironment functionality inside `boostrap/start.php` so `.env.local.php` for example are available and selected correctly.

```
$env = $app->detectEnvironment(array(
  'local' => array('your-machine-name'),
));
```

Next setup .env files and a .env.example.php so required defaults are documented.

`.env.local.php`

```
<?php
return array(
  'DATABASE_NAME' => 'my_database',
  'DATABASE_USER' => 'username',
  'DATABASE_PASSWORD' => 'totally_secure_password'
);
```

Next update all files in `app/config/*.php` with the env() polyfill:


Without polyfill:

    ```
    'host'      => if(isset($_ENV['DATABASEHOST']) ? $_ENV['DATABASE_HOST'] : 'localhost',
    'database'  => if(isset($_ENV['DATABASE_NAME']) ? $_ENV['DATABASE_NAME'] : 'default_db',
    'username'  => if(isset($_ENV['DATABASE_USERNAME']) ? $_ENV['DATABASE_USERNAME'] : 'default_user',
    'password'  => if(isset($_ENV['DATABASE_PASSWORD']) ? $_ENV['DATABASE_PASSWORD'] : 'default_pass',
    ```

With polyfill:

    ```
    'host'      => env(DATABASE_HOST, 'localhost')
    'database'  => env('DATABASE_NAME', 'default_db'),
    'username'  => env('DATABASE_USER', 'default_user'),
    'password'  => env('DATABASE_PASSWORD', 'default_pass')
    ````
