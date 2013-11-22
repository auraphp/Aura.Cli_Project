<?php
/**
 * @var Aura\Di\Container $di The dependency injection container.
 */

// support objects
$dispatcher = $di->get('cli_dispatcher');
$context    = $di->get('cli_context');
$stdio      = $di->get('cli_stdio');

// add commands by name
$dispatcher->setObject('hello', function ($name = 'world') use ($context, $stdio) {
    $stdio->outln("Hello {$name}!");
});
