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

// hand off to the kernel script and get back the exit status
$status = require dirname(__DIR__) . '/vendor/aura/cli-kernel/scripts/kernel.php';
exit($status);
