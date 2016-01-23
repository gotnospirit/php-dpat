<?php
  /**
   * @package     	DataSource
   * @class       	XpathExpression
   * @author      	Jimmy CHARLEBOIS
   * @date        	21-11-2006
   * @brief       	Encapsulation d'une expression XPath pour DataSource
   */
  System::import( 'System.Interfaces.DataSource.IDataSourceExpression' );

  class XpathExpression implements IDataSourceExpression {
    private $_declaration;

    public function __construct( $declaration ) {
      $this->_declaration = $declaration;
    }

    public function toString() {
      return $this->_declaration;
    }
  }
?>