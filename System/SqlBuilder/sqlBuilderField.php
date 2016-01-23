<?php
  /**
   * @package     	SqlBuilder
   * @class       	sqlBuilderField
   * @author      	Jimmy CHARLEBOIS
   * @date        	27-04-2007
   * @brief       	
   */

  class sqlBuilderField {
    public $tableAlias;
    public $fieldName;
    public $alias;

    public function __construct( $tableAlias, $fieldName, $alias = null ) {
      $this->fieldName = $fieldName;
      $this->tableAlias = $tableAlias;
      $this->alias = $alias;
    }

    public function __toString() {
      if ( !is_null( $this->alias ) )
        return sprintf( '%s.%s AS %s', $this->tableAlias, $this->fieldName, $this->alias );
      else
        return sprintf( '%s.%s', $this->tableAlias, $this->fieldName );
    }
  }
?>