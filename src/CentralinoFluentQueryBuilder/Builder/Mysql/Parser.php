<?php namespace CentralinoFluentQueryBuilder\Builder\Mysql;

class Parser extends Builder
{
  public function __construct()
  {
    
  }

  public function parse()
  {
    $sql = '';
    $sql .= $this->_parseSelect();
    $sql .= $this->_parseFrom();
    $sql .= $this->_parseJoins();
    $sql .= $this->_parseWheres();

    return $sql;
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

      foreach (self::$_build['join'] as $table => $joins) 
      {
        foreach ($joins as $joinposition => $join) 
        {
          $sql .= 'INNER JOIN '.$table. (!empty($join->alias) ? ' AS '.$join->alias : '' ).' ON ';

          if($join instanceof Join)
          {
            $sql .= $this->_parseConditions($join->conditions);
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
          $sql .= $this->_parseConditions($where->conditions);          
        }
      }
      return $sql;
    } 
  }

  private function _parseConditions($conditions, &$sql = '', $nested = false)
  {
    foreach ($conditions as $conditionposition => $condition) 
    {
      if($condition instanceof \ArrayObject)
      {
        $sql .= '( ';
        $this->_parseConditions($condition, $sql, true);
      }
      
      if($condition instanceof Condition)
      {
        $sql .= $this->_parseCondition($condition, $conditionposition);
      }
    }

    if($nested)
    {
      $sql .= $nested ? ') ' : '';
    }

    return $sql;
  }

  private function _parseCondition(Condition $condition, $conditionposition)
  {
    $sql = '';
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
    return $sql;
  }
}