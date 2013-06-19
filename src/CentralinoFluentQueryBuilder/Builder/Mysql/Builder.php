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
        $this->_conditionposition = count(self::$_build[$this->_type][$this->table][$this->_joinposition]->conditions);
      }
      elseif($this instanceof Where)
      {
        $this->_conditionposition = count(self::$_build[$this->_type][$this->_whereposition]->conditions); 
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
        self::$_build[$this->_type][$this->table][$this->_joinposition]->conditions[$this->_conditionposition][] = $condition;
      }
      elseif ($this instanceof Where) 
      {
        self::$_build[$this->_type][$this->_whereposition]->conditions[$this->_conditionposition][] = $condition;
      }
    }
    else
    {
      if($this instanceof Join)
      {
        self::$_build[$this->_type][$this->table][$this->_joinposition]->conditions[] = $condition;   
      }
      elseif($this instanceof Where)
      {
        self::$_build[$this->_type][$this->_whereposition]->conditions[] = $condition;
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
    $sql = '';
    $sql .= $this->_parseSelect();
    $sql .= $this->_parseFrom();
    $sql .= $this->_parseJoins();
    $sql .= $this->_parseWheres();

    echo $sql;

    echo '<pre>';
    print_r(self::$_build);
  }

  private function _parseSelect()
  {
    if(isset(self::$_build['select']))
    {
      $fields = implode(' , ', self::$_build['select']);
      return 'SELECT '.$fields.' ';
    }
  }

  private function _parseFrom()
  {
    if(!empty(static::$_table))
    {
      return 'FROM '.static::$_table.' ';
    }
  }

  private function _parseJoins()
  {
    $sql = '';

    if(isset(self::$_build['join']))
    {
      $tables = array_keys(self::$_build['join']);

      foreach ($tables as $table) 
      {
        $sql = 'INNER JOIN '.$table.' ON ';
        foreach (self::$_build['join'][$table] as $joinposition => $join) 
        {
          if($joinposition !== 0)
          {
            $sql .= $join->logicaloperator.' ';
          }

          if($join instanceof Join)
          {
            $nested = is_array($join->conditions[0]) ? true : false;

            $sql .= $nested ? ' ( ' : '';

            $sql .= $this->_parseConditions($join->conditions);

            $sql .= $nested ? ' ) ' : '';
          }
        }
      }
    }

    return $sql;
  }

  private function _parseWheres()
  {
    if(isset(self::$_build['where']))
    {
      $sql = 'WHERE ';
      foreach (self::$_build['where'] as $conditionposition => $where) 
      {
        if($conditionposition !== 0)
        {
          $sql .= $where->logicaloperator.' ';
        }

        if($where instanceof Where)
        {
          $nested = is_array($where->conditions[0]) ? true : false;

          $sql .= $nested ? ' ( ' : '';

          $sql .= $this->_parseConditions($where->conditions);

          $sql .= $nested ? ' ) ' : '';
        }
      }
      return $sql;
    } 
  }

  private function _parseConditions($conditions)
  {
    $sql = '';

    $conditions = is_array($conditions[0]) ? $conditions[0] : $conditions;

    foreach ($conditions as $conditionposition => $condition) 
    {
      if($condition instanceof Condition)
      {
        if($conditionposition !== 0)
        {
          $sql .= $condition->logicaloperator.' ';
        }

        switch ($condition->type) 
        {
          case 'compare':
            $left     = $condition->arguments['left'];
            $operator = $condition->arguments['operator'];
            $right    = $condition->arguments['right'];

            $sql .= $left.' '.$operator.' '.$right.' ';
            break;

         case 'between':
            $left     = $condition->arguments['left'];
            $min      = $condition->arguments['min'];
            $max      = $condition->arguments['max'];

            $sql .= $left.' BETWEEN '.$min.' AND '.$max.' ';
            break;

         case 'in':
            $left     = $condition->arguments['left'];
            $list     = $condition->arguments['list'];

            $sql .= $left.' IN ('.implode(', ', $list).') '; 
            break;

          case 'notin':
            $left     = $condition->arguments['left'];
            $list     = $condition->arguments['list'];

            $sql .= $left.' NOT IN ('.implode(', ', $list).') '; 
            break;

          case 'isnull':
            $left     = $condition->arguments['left'];

            $sql .= $left.' IS NULL '; 
            break;

          case 'isnotnull':
            $left     = $condition->arguments['left'];

            $sql .= $left.' IS NOT NULL '; 
            break;
          
          case 'like':
            $left     = $condition->arguments['left'];
            $contains = $condition->arguments['contains'];

            $sql .= $left.' LIKE ("%'.$contains.'%") '; 
            break;
          
          case 'notlike':
            $left     = $condition->arguments['left'];
            $contains = $condition->arguments['contains'];

            $sql .= $left.' NOT LIKE ("%'.$contains.'%") '; 
            break;

          default:
            # code...
            break;
        }
      }
    }

    return $sql;
  }
}

