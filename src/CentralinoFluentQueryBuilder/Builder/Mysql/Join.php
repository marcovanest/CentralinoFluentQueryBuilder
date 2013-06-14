<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Join extends Builder
{
  public $parameters = array();

  public $table;

  public $on_position;

  public function __construct($table)
  {
    $this->table = $table;   
    $this->_type = 'join';   

    if(!isset(parent::$_build[$this->_type]))
    {
      parent::$_build[$this->_type] = array();
    }
  }

  public function on($firstcolumn, $operator = null, $secondcolumn = null, $type = 'AND')
  {
    $table      = $this->table;
    $arguments  = func_get_args();

    $condition = new Condition('compare');
    $condition->compare($table, $arguments);

    parent::addCondition($condition);
     
  }
}