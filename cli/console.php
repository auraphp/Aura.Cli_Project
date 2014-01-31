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

// invoke the project kernel script
require dirname(__DIR__) . '/vendor/aura/project-kernel/scripts/kernel.php';

// create and invoke a cli kernel
$cli_kernel = $di->newInstance('Aura\Cli_Kernel\CliKernel');
$status = $cli_kernel();
exit($status);
