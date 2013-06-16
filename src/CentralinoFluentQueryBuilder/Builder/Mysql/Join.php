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

    if(!isset(parent::$_build[$this->_type][$this->table]))
    {
      parent::$_build[$this->_type][$this->table] = array();
    }
  }

  public function on($firstcolumn, $operator = null, $secondcolumn = null, $type = 'AND')
  {
    $arguments  = func_get_args();

    $condition = new Condition('compare', $this->table);
    $condition->compare($arguments);

    parent::addCondition($condition);
     
  }
}