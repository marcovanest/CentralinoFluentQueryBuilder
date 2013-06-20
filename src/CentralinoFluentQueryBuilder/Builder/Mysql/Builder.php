<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

use CentralinoFluentQueryBuilder\Builder\General;

class Builder extends General
{
  private $_nested = false;

  protected static $_build = array();

  protected $_type;

  protected $_whereposition;

  protected $_conditionposition;

  protected $_joinposition;

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

  public function or_where($table = null)
  {
    return new Where($table, 'OR');
  }

  public function nested(\Closure $function)
  {
    $this->_nested = true;

    if(is_callable($function))
    {
      if($this instanceof Join)
      {
        $this->_conditionposition = self::$_build[$this->_type][$this->table][$this->_joinposition]->conditions->count();
      }
      elseif($this instanceof Where)
      {
        $this->_conditionposition = self::$_build[$this->_type][$this->_whereposition]->conditions->count(); 
      }
     
      call_user_func($function, $this);
    }

    $this->_nested = false;

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
    if($this->_nested)
    {
      if($this instanceof Join)
      {
        if(!isset(self::$_build[$this->_type][$this->table][$this->_joinposition]->conditions[$this->_conditionposition]))
        {
          self::$_build[$this->_type][$this->table][$this->_joinposition]->conditions[$this->_conditionposition] = new \ArrayObject();
        }
        self::$_build[$this->_type][$this->table][$this->_joinposition]->conditions[$this->_conditionposition]->append($condition);
      }
      elseif ($this instanceof Where) 
      {
        if(!isset(self::$_build[$this->_type][$this->_whereposition]->conditions[$this->_conditionposition]))
        {
          self::$_build[$this->_type][$this->table][$this->_joinposition]->conditions[$this->_conditionposition] = new \ArrayObject();
        }
        self::$_build[$this->_type][$this->_whereposition]->conditions[$this->_conditionposition]->append($condition);
      }
    }
    else
    {
      if($this instanceof Join)
      {
        self::$_build[$this->_type][$this->table][$this->_joinposition]->conditions->append($condition);   
      }
      elseif($this instanceof Where)
      {
        self::$_build[$this->_type][$this->_whereposition]->conditions->append($condition);
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
    $parser = new Parser();
    return $parser->parse();
  }
}

