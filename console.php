<?php
use Aura\Cli_Kernel\CliKernelFactory;

// the project base directory
$base = __DIR__;

// config mode
$file = str_replace("/", DIRECTORY_SEPARATOR, "{$base}/config/_mode");
$mode = trim(file_get_contents($file));
if (! $mode) {
    $mode = "default";
}

// autoloader
$loader = require "{$base}/vendor/autoload.php";

// create the project kernel, invoke it, and exit with its status code
$factory = new CliKernelFactory($base, $mode, $loader);
$status = (int) $kernel->__invoke();
exit($status);
