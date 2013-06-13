<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Join extends Builder
{
  public $parameters = array();

  public $table;

  public function __construct($table)
  {
    $this->table = $table;   
    $this->_type = 'join';   
  }

  public function on($firstcolumn, $operator = null, $secondcolumn = null, $type = 'AND')
  {
    $condition = new Condition();
    $condition->compare(compact('firstcolumn', 'operator', 'secondcolumn', 'type'));
    self::$_build[$this->_type][] = $condition;
  }

}