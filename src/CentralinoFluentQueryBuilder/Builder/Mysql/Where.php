<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Where extends Builder
{
  public $parameters = array();

  public $where_position;

  public $table;

  public function __construct($table)
  { 
    $this->table = $table;   
    $this->_type = 'where';  

    if(!isset(parent::$_build[$this->_type]))
    {
      parent::$_build[$this->_type] = array();
    }
  }

  public function compare()
  {  
    $table      = $this->table;
    $arguments  = func_get_args();

    $condition = new Condition('compare');
    $condition->compare($table, $arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function between()
  {
    $table      = $this->table;
    $arguments  = func_get_args();

    $condition = new Condition('between');
    $condition->range($table, $arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function in()
  {
    $table      = $this->table;
    $arguments  = func_get_args();

    $condition = new Condition('in');
    $condition->contains($table, $arguments);

    parent::addCondition($condition);

    return $this;
  }

  public function exists()
  {

  }

}