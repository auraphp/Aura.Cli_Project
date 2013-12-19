<?php
/**
 * 
 * This file is part of Aura for PHP.
 * 
 * @package Aura.Cli_Project
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 * @var Aura\Di\Container $di The DI container.
 * 
 */

// get the project and logger services
$project = $di->get('project');
$logger = $di->get('logger');

// add a log handler
$mode = $project->getMode();
$file = $project->getTmpPath("log/{$mode}.cli.log");
$logger->pushHandler($di->newInstance('Monolog\Handler\StreamHandler', array(
    'stream' => $file,
)));
