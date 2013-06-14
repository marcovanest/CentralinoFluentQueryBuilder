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
    $arguments    = func_get_args();
    $numargument  = func_num_args();

    echo '<pre>';
    print_r($arguments);


    $firstcolumn  = $numargument >= 3 ? $arguments[0] : $this->table;
    $operator     = $numargument >= 3 ? $arguments[1] : $arguments[0];
    $secondcolumn = $numargument >= 3 ? $arguments[2] : $arguments[1];

    $type         = $numargument >= 3 ? $arguments[3] : $arguments[2];

    $condition = new Condition('compare');
    $condition->compare(compact('firstcolumn', 'operator', 'secondcolumn', 'type'));

    parent::addCondition($condition);

    return $this;
  }

  public function between()
  {
    $arguments    = func_get_args();
    $numargument  = func_num_args();

    $column       = $numargument > 2 ? $arguments[0] : $this->table;
    $firstvalue   = $numargument > 2 ? $arguments[1] : $arguments[0];
    $secondvalue  = $numargument > 2 ? $arguments[2] : $arguments[1];

    $condition = new Condition('between');
    $condition->range(compact('column', 'firstvalue', 'secondvalue'));

    parent::addCondition($condition);

    return $this;
  }

  public function in()
  {
    $arguments   = func_get_args();
    $numargument = func_num_args();

    $column = $numargument > 1 ? $arguments[0] : $this->table;
    $values = $numargument > 1 ? $arguments[1] : $arguments[0];

    $condition = new Condition('in');
    $condition->contains(compact('column', 'values'));

    parent::addCondition($condition);

    return $this;
  }

  public function exists()
  {

  }

}