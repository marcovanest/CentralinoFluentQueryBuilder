<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

use CentralinoFluentQueryBuilder\Builder\General;

class Builder extends General
{
  protected $nested = false;

  protected static $_build = array();

  protected $_type;

  public function __construct()
  {
    
  }

  public function select(array $fields)
  {
    return new Select($fields);
  }

  public function join($table)
  {
    return new Join($table);
  }

  public function where($table = null)
  {
    return new Where($table);
  }

  public function nested(\Closure $function)
  {
    $this->nested = true;

    if(is_callable($function))
    {
      if($this instanceof Join)
      {
        $this->conditionposition = count(self::$_build[$this->_type][$this->table]);
      }
      elseif($this instanceof Where)
      {
        $this->conditionposition = count(self::$_build[$this->_type]); 
      }
     

      call_user_func($function, $this);
    }

    $this->nested = false;

    return $this;
  }

  protected function prepareArguments($left, $arguments)
  {
    if(empty($left))
    {
      return $arguments;
    }
    else
    {
      array_unshift($arguments, $left);

      return $arguments;
    }
  }

  protected function addCondition($condition)
  {
    if($this->nested)
    {
      if($this instanceof Join)
      {
        self::$_build[$this->_type][$this->table][$this->conditionposition][] = $condition;
      }
      elseif ($this instanceof Where) 
      {
        self::$_build[$this->_type][$this->conditionposition][] = $condition;
      }
    }
    else
    {
      if($this instanceof Join)
      {
        self::$_build[$this->_type][$this->table][] = $condition;   
      }
      elseif($this instanceof Where)
      {
        self::$_build[$this->_type][] = $condition;   
      }
    }     
  }
  
  public function limit($offset, $amountofrows)
  {
    self::$_build['limit'] = compact('offset', 'amountofrows');

    return $this;
  }

  public function order($column, $direction)
  {
    self::$_build['order'][] = compact('column', 'direction');

    return $this;
  }

  public function group($column)
  {
    self::$_build['group'][] = compact('column');

    return $this;
  }

  public function transform()
  {
    echo '<pre>';
    print_r(self::$_build);
  }
}
