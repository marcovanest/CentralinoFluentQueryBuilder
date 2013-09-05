<?php namespace CentralinoFluentQueryBuilder\Builder;

use CentralinoFluentQueryBuilder\Builder\Interfaces;

class Parser
{
  private $_dms;

  public function __construct($dms)
  {
    $this->_dms = $dms;
  }

  public function parse()
  {
    $sql = '';
    $sql .= $this->_parseDMS();

    return $sql;
  }

  private function _parseDMS()
  {
    $sql = '';

    if($this->_dms instanceof Interfaces\Select)
    {
      $sql .= $this->_parseSelect();
      $sql .= $this->_parseJoins();
      $sql .= $this->_parseWheres();
      $sql .= $this->_parseLimit();
      $sql .= $this->_parseOrder();
      $sql .= $this->_parseGroup();
    }
    elseif($this->_dms instanceof Interfaces\Insert)
    {
      return $this->_parseInsert();
    }

    return $sql;
  }

  private function _parseSelect()
  {
    $columns        = '';
    $selectcolumns  = $this->_dms->getColumns();
    $total          = count($selectcolumns);
    $columncounter  = 1;

    foreach ($selectcolumns as $column) 
    {
      $seperator = $total != $columncounter ? ', ' : '';
      $table     = ! empty($column->table) ? $column->table . '.' : '';
      $columncounter++;

      switch($column->getType())
      {
        case 'normal':
          $columns .= $table . $column->getName() . $seperator;
          break;

        case 'count':
          $columns .= 'COUNT(' . $table . $column->getName() . ') ' . $seperator;
          break;

        case 'avg':
          $columns .= 'AVG(' . $table . $column->getName() . ') ' . $seperator;
          break;

        case 'sum':
          $columns .= 'SUM(' . $table.$column->getName().') ' .$seperator;
          break;

        case 'min':
          $columns .= 'MIN(' . $table . $column->getName() . ') ' . $seperator;
          break;

        case 'max':
          $columns .= 'MAX(' . $table . $column->getName() . ') ' . $seperator;
          break;
      }      
    }

    $target = $this->_dms->getTarget();

    $table  = $target->getTable();
    $alias  = $target->getAlias();

    return 'SELECT ' . $columns . ' FROM ' . $table . ( ! empty($alias) ? ' AS ' . $alias : '' ) . ' ';
  }

  private function _parseInsert()
  {
    $insertcolumns  = $this->_dms->getColumns();

    $columns = array();
    $values  = array();

    foreach ($insertcolumns as $column) 
    {
      $columns[] = $column->getName();
      $values[]  = $column->getValue();
    }

    $target = $this->_dms->getTarget();

    $table  = $target->getTable();
    $alias  = $target->getAlias();

    $insertselect = $this->_dms->getSelect();
    if( $insertselect instanceof Interfaces\Select)
    {
      $selectparser = new Parser($insertselect);
      $parse        = $selectparser->parse();
    }

    return 'INSERT INTO ' . $table . ( ! empty($alias) ? ' AS ' . $alias : '' ) . ' ';
  }

  private function _parseJoins()
  {
    $sql = '';

    $dmsjoins = $this->_dms->getJoins();

    if( is_array($dmsjoins) )
    {
      foreach ($dmsjoins as $table => $joins) 
      {
        foreach ($joins as $joinposition => $join) 
        {
          $alias = $join->getAlias();
          $type  = strtoupper($join->getType());

          $sql .= $type . ' JOIN ' . $table . ( ! empty($alias) ? ' AS ' . $alias : '' ) . ' ON ';

          if($join instanceof Interfaces\Join)
          {
            $conditions      = $join->getConditions();
            $nestedoperators = $join->getNestedOperators();
            $logicaloperator = isset($nestedoperators[$joinposition]) ? $nestedoperators[$joinposition] : null;

            $sql .= $this->_parseConditions($conditions, $logicaloperator);
          }
        }
      }
    }

    return $sql;
  }

  private function _parseWheres()
  {
    $dmswheres = $this->_dms->getWheres();

    if( ! empty($dmswheres) )
    {
      $sql = 'WHERE ';
      foreach ($dmswheres as $whereposition => $where) 
      {
        if($whereposition !== 0)
        {
          $sql .= $where->getLogicalOperator() . ' ';
        }

        if($where instanceof Interfaces\Where)
        {
          $conditions      = $where->getConditions();
          $nestedoperators = $where->getNestedOperators();
          $logicaloperator = isset($nestedoperators[$whereposition]) ? $nestedoperators[$whereposition] : null;

          $sql .= $this->_parseConditions($conditions, $logicaloperator);          
        }
      }
      return $sql;
    } 
  }

  private function _parseLimit()
  {
    $limit = $this->_dms->getLimit();

    if( ! is_null($limit) )
    {
      $offset       = $limit->getOffset();
      $amountofrows = $limit->getAmountOfRows();

      $sql = 'LIMIT ' . $offset . ( ! empty($amountofrows) ? ',' . $amountofrows : '') . ' ';
      return $sql;
    }
  } 

  private function _parseOrder()
  {
    $order = $this->_dms->getOrder();

    if( ! is_null($order) )
    {
      $total         = count($order);
      $columncounter = 1;

      $sql = 'ORDER BY ';
      foreach ($order as $orderposition => $order) 
      {
        if($order instanceof Interfaces\Order)
        {
          $column     = $order->getColumn()->getName();
          $direction  = $order->getDirection();

          $sql .= $column . ' ' . $direction;
          $sql .= $columncounter!=$total ? ', ' : '';

          $columncounter++; 
        }
      }
      return $sql;
    }    
  }

  private function _parseGroup()
  {
    $group = $this->_dms->getGroup();

    if( ! is_null($group))
    {
      $total         = count($group);
      $columncounter = 1;

      $sql = 'GROUP BY ';

      foreach ($group as $groupposition => $group) 
      {
        if($group instanceof Interfaces\Group)
        {
          $column = $group->getColumn()->getName();

          $sql .= $column;      
          $sql .= $columncounter != $total ? ', ' : '';

          $columncounter++; 
        }
      }
      return $sql;
    }    
  }

  private function _parseConditions($conditions, $logicaloperators = null, &$sql = '', $nested = false)
  {
    foreach ($conditions as $conditionposition => $condition) 
    {
      if(is_array($condition))
      {
        $sql .= ($conditionposition != 0 ? $logicaloperators.' ' : '') . '( ';
        $this->_parseConditions($condition, null, $sql, true);
      }
      
      if($condition instanceof General\Condition)
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

  private function _parseCondition(General\Condition $condition, $conditionposition)
  {
    $sql = '';
    if($conditionposition !== 0)
    {
      $sql .= $condition->getLogicalOperator() . ' ';
    }

    $arguments = $condition->getArguments();
    $column    = $arguments['column'];

    switch ($condition->getType()) 
    {
      case 'compare':
        $operator = $arguments['operator'];
        $right    = $arguments['right'];

        $sql .= $column->getName() . ' ' . $operator . ' ' . $right . ' ';
        break;

     case 'between':
        $min = $arguments['min'];
        $max = $arguments['max'];

        $sql .= $column->getName() . ' BETWEEN ' . $min . ' AND ' . $max . ' ';
        break;

     case 'notbetween':
        $min = $arguments['min'];
        $max = $arguments['max'];

        $sql .= $column->getName() . ' NOT BETWEEN ' . $min . ' AND ' . $max . ' ';
        break;

     case 'in':
        $list = $arguments['list'];

        $sql .= $column->getName() . ' IN (' . implode(', ', $list) . ') '; 
        break;

      case 'notin':
        $list = $arguments['list'];

        $sql .= $column->getName() . ' NOT IN (' . implode(', ', $list) . ') '; 
        break;

      case 'isnull':
        $sql .= $column->getName() . ' IS NULL '; 
        break;

      case 'isnotnull':
        $sql .= $column->getName() . ' IS NOT NULL '; 
        break;
      
      case 'like':
        $contains = $arguments['contains'];

        $sql .= $column->getName() . ' LIKE ("%' . $contains . '%") '; 
        break;
      
      case 'notlike':
        $contains = $arguments['contains'];

        $sql .= $column->getName() . ' NOT LIKE ("%' . $contains . '%") '; 
        break;

      default:
        # code...
        break;
    }
    return $sql;
  }
}