<?php
/**
 * @var Aura\Di\Container $di The dependency injection container.
 */

// support objects
$logger     = $di->get('logger');
$dispatcher = $di->get('cli_dispatcher');
$context    = $di->get('cli_context');
$stdio      = $di->get('cli_stdio');

// send logging to syslog instead of stdio
$logger->pushHandler($di->newInstance('Monolog\Handler\SyslogHandler', array(
    'ident' => 'aura-cli-project',
)));

// the command param name
$dispatcher->setObjectParam('command');

// add commands by name
$dispatcher->setObject('hello', function ($name = 'world') use ($context, $stdio) {
    $stdio->outln("Hello {$name}!");
});
