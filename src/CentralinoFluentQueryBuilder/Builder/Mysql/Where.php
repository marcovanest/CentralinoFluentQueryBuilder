<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Where extends Builder
{
  public $parameters = array();

  public $where_position;

  public function __construct()
  { 
    $this->_type = 'where';  

    if(!isset(self::$_build[$this->_type]))
    {
      self::$_build[$this->_type] = array();
    }
  }

  public function where($firstcolumn= null, $operator = null, $secondcolumn = null, $type = 'AND')
  {
    $condition = new Condition();
    $condition->compare(compact('firstcolumn', 'operator', 'secondcolumn', 'type'));

    if($this->nested)
    {
      self::$_build[$this->_type][$this->where_position][] = $condition;   
    }
    else
    {
      self::$_build[$this->_type][] = $condition;   
    }
  }

}