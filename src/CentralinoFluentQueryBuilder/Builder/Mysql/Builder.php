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

  public function where()
  {
    return new Where();
  }

  public function nested(\Closure $function)
  {
    $this->nested = true;

    if(is_callable($function))
    {
      if($this instanceof Join)
      {
        $this->on_position = count(static::$_build[$this->_type][$this->table]);
      }
      if($this instanceof Where)
      {
        $this->where_position = count(static::$_build[$this->_type]);
      }

      call_user_func($function, $this);
    }

    $this->nested = false;

    return $this;
  }

  protected function addCondition($condition)
  {
    if($this instanceof Join)
    {
      if($this->nested)
      {
        self::$_build[$this->_type][$this->table][$this->on_position][] = $condition;
      }
      else
      {
        self::$_build[$this->_type][$this->table][] = $condition;   
      }
          
    }
    if($this instanceof Where)
    {
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

  public function limit($offset, $amountofrows)
  {
    static::$_build['limit'] = compact('offset', 'amountofrows');

    return $this;
  }

  public function order($column, $direction)
  {
    static::$_build['order'][] = compact('column', 'direction');

    return $this;
  }

  public function group($column)
  {
    static::$_build['group'][] = compact('column');

    return $this;
  }

  public function transform()
  {
    echo '<pre>';
    print_r(self::$_build);
  }
}
