<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Where extends Builder
{
  public $parameters = array();

  public $where_position;

  public function __construct()
  { 
    $this->_type = 'where';  

    if(!isset(parent::$_build[$this->_type]))
    {
      parent::$_build[$this->_type] = array();
    }
  }

  public function where($firstcolumn= null, $operator = null, $secondcolumn = null, $type = 'AND')
  {
    $condition = new Condition();
    $condition->compare(compact('firstcolumn', 'operator', 'secondcolumn', 'type'));

    parent::addCondition($condition);

    return $this;
  }

  public function between($column, $firstvalue, $secondvalue)
  {
    $condition = new Condition();
    $condition->range(compact('column', 'firstvalue', 'secondvalue'));

    parent::addCondition($condition);

    return $this;
  }

  public function in($column, $values)
  {
    $condition = new Condition();
    $condition->contains(compact('column', 'values'));

    parent::addCondition($condition);

    return $this;
  }

  public function exists()
  {

  }

}