<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Target extends Syntax
{
  private $_table;
  private $_alias;

  public function __construct($table)
  {
    $this->_table = $table;
  }

  /**
   * return the target table name
   * 
   * @return string
   */
  public function getTable()
  {
    return $this->_table;
  }

  /**
   * return the target table alias
   * 
   * @return string
   */
  public function getAlias()
  {
    return $this->_alias;
  }

  /**
   * sets the target table alias
   * 
   * @param  string $alias
   * @return Target
   */
  public function alias($alias)
  {
    $this->_alias = $alias;

    return $this;
  }
}