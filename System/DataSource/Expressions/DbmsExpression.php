<?php
  /**
   * @package       DataSource
   * @class         DbmsExpression
   * @author        Jimmy CHARLEBOIS
   * @date          02-01-2007
   * @brief         Encapsulation d'une requête SQL pour DataSource
   */
  System::import( 'System.Interfaces.DataSource.IDataSourceExpression' );

  class DbmsExpression implements IDataSourceExpression {
    private $_declaration;

    public function __construct( $declaration ) {
      $this->_declaration = $declaration;
    }

    public function toString() {
      return $this->_declaration;
    }
  }
?>