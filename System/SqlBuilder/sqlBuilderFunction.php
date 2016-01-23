<?php
  /**
   * @package     	SqlBuilder
   * @class       	sqlBuilderFunction
   * @author      	Jimmy CHARLEBOIS
   * @date        	27-04-2007
   * @brief       	
   */

  class sqlBuilderFunction {
    public $expression;
    public $alias;

    public function __construct( $expression, $alias ) {
      $this->expression = $expression;
      $this->alias = $alias;
    }

    public function __toString() {
      return sprintf( '%s AS %s', $this->expression, $this->alias );
    }
  }
?>