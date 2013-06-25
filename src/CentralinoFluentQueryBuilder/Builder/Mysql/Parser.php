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
    $columns = '';
    if(isset(self::$_build['select']))
    {
      $total = self::$_build['select']->count();
      $columncounter = 1;
      foreach (self::$_build['select'] as $column) 
      {
        $seperator = $total != $columncounter ? ', ' : '';
        $table     = !empty($column->table) ? $column->table.'.' : '';
        $columncounter++;

        switch($column->type)
        {
          case 'normal':
            $columns .= $table.$column->name.$seperator;
            break;

          case 'count':
            $columns .= 'COUNT('.$table.$column->name.') '.$seperator;
            break;

          case 'avg':
            $columns .= 'AVG('.$table.$column->name.') '.$seperator;
            break;

          case 'sum':
            $columns .= 'SUM('.$table.$column->name.') '.$seperator;
            break;

          case 'min':
            $columns .= 'MIN('.$table.$column->name.') '.$seperator;
            break;

          case 'max':
            $columns .= 'MAX('.$table.$column->name.') '.$seperator;
            break;
        }      
      }

      return 'SELECT '.$columns.' ';
    }
  }

  private function _parseFrom()
  {
    if(isset(parent::$_build['from']))
    {
      $from = parent::$_build['from'];
      return 'FROM '.$from->table. (!empty($from->alias) ? ' AS '.$from->alias : '' ).' ';
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
            $sql .= $this->_parseConditions($join->conditions, $join->_nestedoperators[$joinposition]);
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
      foreach (self::$_build['where'] as $whereposition => $where) 
      {
        if($whereposition !== 0)
        {
          $sql .= $where->logicaloperator.' ';
        }

        if($where instanceof Where)
        {
          $sql .= $this->_parseConditions($where->conditions, $where->_nestedoperators[$whereposition]);          
        }
      }
      return $sql;
    } 
  }

  private function _parseConditions($conditions, $logicaloperators = null, &$sql = '', $nested = false)
  {
    foreach ($conditions as $conditionposition => $condition) 
    {
      if($condition instanceof \ArrayObject)
      {
        $sql .= ($conditionposition != 0 ? $logicaloperators[$conditionposition] : '').' ( ';
        $this->_parseConditions($condition, null, $sql, true);
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