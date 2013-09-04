<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Builder
{
  private $_nested = false;

  protected static $_build = array();

  protected $_type;

  protected $_conditionposition;

  protected $_nestedoperators;

  public function __construct()
  {
    
  }

  public function select($fields = array())
  {
    return new DMS\Select($fields);
  }

  public function insert($fields = array())
  {
    return new DMS\Insert($fields);
  }

  public function join($table)
  {
    return new Join($table);
  }

  public function left_join($table)
  {
    return new Join($table);
  }

  public function right_join($table)
  {
    return new Join($table);
  }

  public function where($table = null)
  {
    return new Clause\Where($table);
  }

  public function or_where($table = null)
  {
    return new Clause\Where($table, 'OR');
  }

  public function nested(\Closure $function)
  {
    if($this instanceof Join || 
        $this instanceof Clause\Where )  
    {
      return $this->_handleNested($function, 'AND');
    }
  }

  public function or_nested(\Closure $function)
  {
    if($this instanceof Join || 
        $this instanceof Clause\Where )
    {
      return $this->_handleNested($function, 'OR');
    }
  }
  
  public function limit($offset, $amountofrows = null)
  {
    self::$_build['limit'] = compact('offset', 'amountofrows');

    return $this;
  }

  public function order($columns, $direction = null)
  {
    $order = new Clause\Order($columns, $direction);

    return $this;
  }

  public function group($column)
  {
    $order = new Clause\Group($column);

    return $this;
  }

  public function get()
  {
    $parser = new Parser();
    return $parser->parse();
  }

  private function _handleNested($function, $logicaloperator)
  {
    $this->_nested = true;
    $position      = $this->getPosition();

    if(is_callable($function))
    {
      if($this instanceof Join)
      {
        $table = $this->getTable();

        $this->_conditionposition = count(self::$_build[$this->_type][$table][$position]->getConditions());
        $this->_nestedoperators[$position][$this->_conditionposition] = $logicaloperator; 
      }
      elseif($this instanceof Clause\Where)
      {
        $this->_conditionposition = count(self::$_build[$this->_type][$position]->getConditions()); 
        $this->_nestedoperators[$position][$this->_conditionposition] = $logicaloperator; 
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
    $position = $this->getPosition();

    if($this->_nested)
    {
      if($this instanceof Join)
      {
        $table = $this->getTable();

        if(!isset(self::$_build[$this->_type][$table][$position]->conditions[$this->_conditionposition]))
        {
          self::$_build[$this->_type][$table][$position]->conditions[$this->_conditionposition] = array();
        }
        self::$_build[$this->_type][$table][$position]->conditions[$this->_conditionposition][] = $condition;
      }
      elseif ($this instanceof Clause\Where) 
      {
        if(!isset(self::$_build[$this->_type][$position]->conditions[$this->_conditionposition]))
        {
          self::$_build[$this->_type][$position]->conditions[$this->_conditionposition] = array();
        }
        self::$_build[$this->_type][$position]->conditions[$this->_conditionposition][] = $condition;
      }
    }
    else
    {
      if($this instanceof Join)
      {
        $table = $this->getTable();

        self::$_build[$this->_type][$table][$position]->conditions[] = $condition;   
      }
      elseif($this instanceof Clause\Where)
      {
        self::$_build[$this->_type][$position]->conditions[] = $condition;
      }
    }     
  }
}

