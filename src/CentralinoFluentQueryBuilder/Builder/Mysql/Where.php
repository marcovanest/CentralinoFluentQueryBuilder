<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Where extends Builder
{
  public $parameters = array();

  public function __construct()
  { 
    $this->_type = 'where';  
  }

  public function where($firstcolumn= null, $operator = null, $secondcolumn = null, $type = 'AND')
  {
    $condition = new Condition();
    $condition->compare(compact('firstcolumn', 'operator', 'secondcolumn', 'type'));
    self::$_build[$this->_type][] = $condition;
  }

}