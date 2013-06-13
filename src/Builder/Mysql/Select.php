<?php namespace Centralino\Core\DatabaseManager\Statement\Builder\Mysql;

class Select extends Builder
{
  public $fields;

  public function __construct($fields)
  {
    parent::$_build['select'] = $fields;
  }
}