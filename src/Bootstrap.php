<?php namespace CentralinoFluentQueryBuilder;

ini_set('display_errors', 'true');
error_reporting(E_ALL);

/**
 * Set the version
 */
DEFINE('VERSION', 0.1);

/**
 * Set the debug mode
 */
DEFINE('DEBUG', true);

/**
 * Set the working directory to Centralino
 */
chdir(__DIR__);

/**
 * Define of the directory separator alias
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * Define of the namespace separator alias
 */
define('NS', '\\');

/**
 * Define the default php extension
 */
define('EXT', '.php');

/**
 * Define the root dir to the current working directory
 */
define('ROOT', getcwd() . DS);

define('CentralinoFluentQueryBuilder', ROOT . 'CentralinoFluentQueryBuilder' . DS);


require CentralinoFluentQueryBuilder . 'Autoloader' . EXT;

spl_autoload_extensions(EXT);
spl_autoload_register(array('CentralinoFluentQueryBuilder' . NS . 'Autoloader', 'load'));


