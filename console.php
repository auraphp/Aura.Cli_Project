<?php
use Aura\Di\Config;
use Aura\Di\Container;
use Aura\Di\Forge;
use Aura\Cli_Kernel\CliKernel;

// the project base directory
$base = __DIR__;

// autoloader
$loader = require "{$base}/vendor/autoload.php";

// DI container
$di = new Container(new Forge(new Config));

// config mode
$file = str_replace("/", DIRECTORY_SEPARATOR, "{$base}/config/_mode");
$mode = trim(file_get_contents($file));
if (! $mode) {
    $mode = "default";
}

// create and invoke the project kernel
$kernel = new CliKernel($loader, $di, $base, $mode);
$status = $kernel->__invoke();

// exit with the returned status code
exit($status);
