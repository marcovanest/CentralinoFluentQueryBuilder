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

    self::$_build[$this->_type][$this->table] = array();
  }

  public function on($firstcolumn, $operator = null, $secondcolumn = null, $type = 'AND')
  {
    $condition = new Condition();
    $condition->compare(compact('firstcolumn', 'operator', 'secondcolumn', 'type'));

    parent::addCondition($condition);
     
  }

}