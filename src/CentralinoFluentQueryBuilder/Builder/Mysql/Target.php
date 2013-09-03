<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Target extends Builder
{
  public $table;
  public $alias;

  public function __construct($table)
  {
    $this->table = $table;

    parent::$_build = '';

    parent::$_build['target'] = $this;
  }

  public function alias($alias)
  {
    $this->alias = $alias;

    return $this;
  }
}