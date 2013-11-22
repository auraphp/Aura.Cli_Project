# Aura.Cli_Project

Unlike Aura libraries, this Project package has dependencies. It composes
various libraries and an [Aura.Cli_Kernel][] into a minimal framework for
CLI applications.

By "minimal" we mean *very* minimal. The project provides only a dependency
injection container, a configuration system, a command console, context and standard I/O objects, and a logging instance. This is the bare minimum needed
to get a CLI application running.

This minimal implementation should not be taken as "restrictive". The DI
container, coupled with the kernel's two-stage configuration, allows a wide
range of programmatic service definitions. The dispatcher is built with
iterative refactoring in mind, so you can start with micro-framework-like
closure commands, and work your way up to more complex command objects of your
own design.

## Foreword

TBD

## Getting Started

Install via Composer to a {$PROJECT_PATH} of your choosing:

    composer create-project --stability=dev aura/cli-project {$PROJECT_PATH}
    
This will create the project skeleton and install all of the necessary
packages.

Once you have installed the project, go to the project directory and issue
the following command:

    cd {$PROJECT_PATH}
    php console.php hello

You should see the output `Hello world!`. Try passing a name after `hello` to
see `Hello name!`.

Add closure-based commands of your own by editing the `config/default/modify.php` file.
