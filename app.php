<?php

/**
 * This file is part of the [PROJECT NAME].
 *
 * (c) [YOUR NAME/COMPANY].
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

// Determine the current environment using environmental variables, and default
// to prod. This way, you can set an environmental variable in your Apache or
// Nginx config for this specific domain/project, indicating it's environment.
//
// Apache Example:
//
// <VirtualHost *:80>
//     ServerName example.com
//     ...
//     SetEnv SYMFONY_ENV dev
// </VirtualHost>
//
// Nginx Example:
//
// server {
//     server_name example.com;
//     ...
// 
//     location ~ \.php$ {
//         ...
//         fastcgi_param SYMFONY_ENV dev;
//         ...
//     }
// }
$environment = (getenv('SYMFONY_ENV')) ?: 'prod';

// Set a constant for the base Symfony directory, can be useful
define('ROOT_DIR', realpath(__DIR__ . '/../'));

// Get the auto loader
$loader = require_once __DIR__ . '/../app/bootstrap.php.cache';

// Use APC for autoloading to improve performance.
// Change 'sf2' to a unique prefix in order to prevent cache key conflicts
// with other applications also using APC.
/*
$loader = new ApcClassLoader('sf2', $loader);
$loader->register(true);
*/

// Get the main application kernel
require_once __DIR__ . '/../app/AppKernel.php';
//require_once __DIR__.'/../app/AppCache.php';

// Initialize the application
$kernel = new AppKernel($environment, $environment != 'prod');
$kernel->loadClassCache();
//$kernel = new AppCache($kernel);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

