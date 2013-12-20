# Aura.Cli_Project

Unlike Aura libraries, this Project package has dependencies. It composes
various libraries and an [Aura.Cli_Kernel][] into a minimal framework for
CLI applications.

By "minimal" we mean *very* minimal. The project provides only a dependency
injection container, a configuration system, a command console, a pair of
context and standard I/O objects, and a logging instance.

This minimal implementation should not be taken as "restrictive". The DI
container, coupled with the kernel's two-stage configuration, allows a wide
range of programmatic service definitions. The dispatcher is built with
iterative refactoring in mind, so you can start with micro-framework-like
closure commands, and work your way up to more complex command objects of your
own design.

[Aura.Cli_Kernel]: https://github.com/auraphp/Aura.Cli_Kernel

## Foreword

TBD

## Getting Started

Install via Composer to a `{$PROJECT_PATH}` of your choosing:

    composer create-project --stability=dev aura/cli-project {$PROJECT_PATH}
    
This will create the project skeleton and install all of the necessary
packages.

Once you have installed the project, go to the project directory and issue
the following command:

    cd {$PROJECT_PATH}
    php cli/console.php hello

You should see the output `Hello World!`. Try passing a name after `hello` to
see `Hello name!`.

### Configuration

Configuration files are located in `{$PROJECT_PATH}/config` and are organized
into subdirectories by config mode.

The config mode is set by `$_ENV['AURA_CONFIG_MODE']`, either via a shell
variable or the `_env.php` file in the config directory.

The `default` mode directory is always loaded; if the mode is something other
than `default` then the files in that directory will be loaded after `default`.

Aura projects use a two-stage configuration system.

1. First, all `define.php` files are included from the packages and the
project; these define constructor parameters, setter methods, and shared
services through the DI container.

2. After that, the DI container is locked, and all `modify.php` files are
included; these are for retrieving services from the DI container for
programmatic modification.

(TBD: examples)

### Commands

To add routes of your own, edit the
`{$PROJECT_PATH}/config/default/modify/dispatcher.php` file.
Here are two different styles of command definition.

#### Micro-Framework Style

The following is an example of a command where the logic is embedded in the
dispatcher, using the _Context_ and _Stdio_ services along with standard
_Status_ exit codes.

```php
<?php
/**
 * {$PROJECT_PATH}/config/default/modify/dispatcher.php
 */
use Aura\Cli\Status;
$context = $di->get('cli_context');
$stdio = $di->get('cli_stdio');
$dispatcher->setObject('foo', function ($id = null) use ($context, $stdio) {
    if (! $id) {
        $stdio->errln("Please pass an ID.");
        return Status::USAGE;
    }
    
    $id = (int) $id;
    $stdio->outln("You passed " . $id . " as the ID.");
});
?>
```

You can now run the command to see its output.

    cd {$PROJECT_PATH}
    php cli/console.php foo 88

(If you do not pass an ID argument, you will see an error message.)

#### Full-Stack Style

You can migrate from a micro-controller style to a full-stack style (or start
with full-stack style in the first place).

First, define a command class and place it in the project `src/` directory.

```php
<?php
/**
 * {$PROJECT_PATH}/src/App/Commands/FooCommand.php
 */
namespace App\Commands;

use Aura\Cli\Stdio;
use Aura\Cli\Context;
use Aura\Cli\Status;

class FooCommand
{
    public function __construct(Context $context, Stdio $stdio)
    {
        $this->context = $context;
        $this->stdio = $stdio;
    }
    
    public function __invoke($id = null)
    {
        if (! $id) {
            $this->stdio->errln("Please pass an ID.");
            return Status::USAGE;
        }
    
        $id = (int) $id;
        $this->stdio->outln("You passed " . $id . " as the ID.");
    }
}
?>
```

Next, tell the project how to build the _FooCommand_ through the DI
system. Edit the project `config/default/define.php` config file to tell the
DI system to pass _Context_ and _Stdio_ objects to the constructor.

```php
<?php
/**
 * {$PROJECT_PATH}/config/default/define.php
 */
$di->params['App\Commands\FooCommand'] = array(
    'context' => $di->lazyGet('cli_context'),
    'stdio' => $di->lazyGet('cli_stdio'),
);
?>
```

Finally, put the _App\Commands\FooCommand_ object in the dispatcher under the
name `foo` as a lazy-loaded instantiation.

```php
<?php
/**
 * {$PROJECT_PATH}/config/default/modify/dispatcher.php
 */
$dispatcher->setObject('foo', $di->lazyNew('App\Commands\FooCommand'));
?>
```

You can now run the command to see its output.

    cd {$PROJECT_PATH}
    php cli/console.php foo 88

(If you do not pass an ID argument, you will see an error message.)

#### Other Variations

These are only some common variations of dispatcher interactions;
[there are many other combinations][].

[there are many other combinations]: https://github.com/auraphp/Aura.Dispatcher/tree/develop-2#refactoring-to-architecture-changes


### Logging

The project automatically logs to `{$PROJECT_PATH}/tmp/log/{$mode}.log`. If
you want to change the logging behaviors, edit the
`config/default/modify/logger.php` file to modify how Monolog handles entries.
