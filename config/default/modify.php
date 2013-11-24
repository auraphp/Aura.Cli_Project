<?php
/**
 * @var Aura\Di\Container $di The dependency injection container.
 */

// support objects
$dispatcher = $di->get('cli_dispatcher');
$context    = $di->get('cli_context');
$stdio      = $di->get('cli_stdio');

// the command param name
$dispatcher->setObjectParam('command');

// add commands by name
$dispatcher->setObject('hello', function ($name = 'World') use ($context, $stdio) {
    $stdio->outln("Hello {$name}!");
});
