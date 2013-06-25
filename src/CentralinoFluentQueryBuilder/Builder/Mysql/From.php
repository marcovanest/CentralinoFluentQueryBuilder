<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class From extends Builder
{
  public $table;
  public $alias;

  public function __construct($table)
  {
    $this->table = $table;

    parent::$_build = '';

    parent::$_build['from'] = $this;
  }

  public function alias($alias)
  {
    $this->alias = $alias;

    return $this;
  }
}