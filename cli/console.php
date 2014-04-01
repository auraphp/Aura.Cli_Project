<?php
/**
 * 
 * This file is part of Aura for PHP.
 * 
 * @package Aura.Cli_Project
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 */

$path = dirname(__DIR__);
require "{$path}/vendor/autoload.php";
require "{$path}/config/_env.php";

$di = (new \Aura\Project_Kernel\Factory)->newContainer(
    $path,
    $_ENV['AURA_CONFIG_MODE'],
    "{$path}/composer.json",
    "{$path}/vendor/composer/installed.json"
);

$kernel = $di->newInstance('Aura\Cli_Kernel\CliKernel');
$status = $kernel();
exit($status);
