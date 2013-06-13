<?php namespace CentralinoFluentQueryBuilder;

/**
 * Responsible for loading all the undefined classes within the framework
 */
class Autoloader
{

  /**
   * Handles lazy loading classes
   * @param  [string] $class [class name]
   * @return none
   */
  public static function load($class)
  {
    $file = str_replace(array('\\', '_'), '/', $class);

    require ROOT.$file.EXT;
  }
}