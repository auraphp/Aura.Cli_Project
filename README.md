# Aura.Cli_Project

Unlike Aura libraries, this Project package has dependencies. It composes
various libraries and an [Aura.Cli_Kernel][] into a minimal framework for
CLI applications.

By "minimal" we mean *very* minimal. The project provides only a dependency
injection container, a configuration system, a command console, context and
standard I/O objects, and a logging instance.

This minimal implementation should not be taken as "restrictive". The DI
container, coupled with the kernel's two-stage configuration, allows a wide
range of programmatic service definitions. The dispatcher is built with
iterative refactoring in mind, so you can start with micro-framework-like
closure commands, and work your way up to more complex command objects of your
own design.

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
    php console.php hello

You should see the output `Hello World!`. Try passing a name after `hello` to
see `Hello name!`.


### Configuration

Configuration files are located in `{$PROJECT_PATH}/config` and are organized
into subdirectories by operational mode.  (The operational mode is stored in
`_mode` file in the config directory.)

The `default` mode directory is always loaded; if the mode is something other
than `default` then the files in that directory will be loaded after `default`.

Aura projects use a two-stage configuration system.  First, all `define.php`
files are included from the packages and the project; these define params,
setters, and services through the DI container. After that, the DI container
is locked, and all `modify.php` files are included; these are for retrieving
services from the DI container for programmatic modification.

(TBD: examples)

### Commands

To add commands of your own, edit the
`{$PROJECT_PATH}/config/default/modify.php` file. Therein, you will find some
service objects extracted from the DI container:

- `$dispatcher`, an [Aura\Dispatcher\Dispatcher][] instance,
- `$context`, an [Aura\Cli\Context][] instance with [Getopt][] support, and
- `$stdio`, an [Aura\Cli\Stdio][] instance.

[Aura\Dispatcher\Dispatcher]: https://github.com/auraphp/Aura.Dispatcher/tree/develop-2
[Aura\Cli\Context]: https://github.com/auraphp/Aura.Cli/tree/develop-2#context-discovery
[Getopt]: https://github.com/auraphp/Aura.Cli/tree/develop-2#getopt-support
[Aura\Cli\Stdio]: https://github.com/auraphp/Aura.Cli/tree/develop-2#standard-inputoutput-streams

It also provides access to the constants in [Aura\Cli\Status][] for standard
exit codes.

[Aura\Cli\Status]: https://github.com/auraphp/Aura.Cli/tree/develop-2#exit-codes

The following is an example of a command where the logic is embedded in the
dispatcher:

```php
<?php
$dispatcher->setObject('command-name', function ($id = null) use ($context, $stdio) {
    if (! $id) {
        $stdio->errln("Please pass an ID.");
        return Status::USAGE;
    }
    
    $id = (int) $id;
    $stdio->outln("You passed " . $id . " as the ID.");
});
?>
```

Run the command with `php console.php command-name`.

You can use to a lazy-instantiated named object as well:

```php
<?php
$dispatcher->setObject('command-name', $di->lazyNew('Vendor\Package\CommandName'));
?>
```

You can place your `Vendor\Package\CommandName` class at
`{$PROJECT_PATH}/src/Vendor/Package/CommandName.php`, and the dispatcher will
call its `__invoke($id)` method automatically.

These are only some common variations of dispatcher interactions;
[there are many other combinations][].

[there are many other combinations]: https://github.com/auraphp/Aura.Dispatcher/tree/develop-2#refactoring-to-architecture-changes
