<?php
  /**
   * @package     	Dbms
   * @class       	ResultSetMysql
   * @author      	Jimmy CHARLEBOIS
   * @date        	02-01-2007
   * @brief       	Implémentation concrète d'un jeu de résultats pour MySQL
   */
  System::import( 'System.DataSource.Dbms.DbmsResultSet' );
  System::import( 'System.Exceptions.UnsupportedOperationException' );

  class ResultSetMysql extends DbmsResultSet {
    public function __construct( &$res ) {
      parent::__construct( $res );
      $this->setSize( @mysql_num_rows( $res ) );
    }

    public function &previous() {
      $rv = null;
      if ( $this->getPosition() > 0 ) {
        $pos = $this->getPosition() - 1;
        if ( @mysql_data_seek( $this->getResource(), $pos ) ) {
          $rv =& $this->current();
          $this->setPosition( $pos );
        }
      }
      return $rv;
    }

    public function &current() {
      $rv = @mysql_fetch_array( $this->getResource(), MYSQL_ASSOC );
      return $rv;
    }

    public function &next() {
      $rv = null;

      $pos = $this->getPosition() + 1;
      if ( @mysql_data_seek( $this->getResource(), $pos ) ) {
        $rv =& $this->current();
        $this->setPosition( $pos );
      }

      return $rv;
    }

    public function remove() {
      throw new UnsupportedOperationException();
    }

    /**
     * @note    S'agissant d'un resultset connecté, il ne peut être cloné proprement
     * @throw   UnsupportedOperationException
     */
    public function __clone() {
      throw new UnsupportedOperationException();
    }

    public function seek( $position ) {
      return @mysql_data_seek( $this->getResource(), $position );
    }

    public function dispose() {
      return @mysql_free_result( $this->getResource() );
    }
  }
?>