<?php
  /**
   * @package     	DataSource
   * @class       	DbmsMysql
   * @author      	Jimmy CHARLEBOIS
   * @date        	02-01-2007
   * @brief       	Implémentation concrête de DbmsDataSource pour MySQL
   */
  System::import( 'System.DataSource.Dbms.ResultSets.ResultSetMysql' );

  class DbmsMysql extends DbmsDataSource {
    public function __construct( IDataSourceDriver $driver ) {
      parent::__construct( $driver );
    }

    public function connect() {
      if ( is_resource( $this->getResource() ) )
        return true;
      $driver =& $this->getDriver();
      $res = @mysql_connect( $driver->getHost(), $driver->getUsername(), $driver->getPassword() );
      if ( !$res )
        throw new Exception( 'Unable to connect with '.$driver->toString() );
      $this->setResource( $res );
      return @mysql_select_db( $driver->getDbName(), $res );
    }

    public function close() {
    /**
     * @todo    Voir comment fermer automatiquement les connexions
     * enregistrement auprès de System ?
     */
      $res =& $this->getResource();
      if ( !is_resource( $res ) )
        return true;
      return @mysql_close( $res );
    }

    public function execute( $sql_request ) {
      $rv = null;
      $res =& $this->getResource();
      $rs = @mysql_query( $sql_request, $res );
      if ( $rs === false )
        throw new Exception( '['.mysql_errno( $res ).'] '.mysql_error( $res ) );
      if ( is_resource( $rs ) )
        $rv =& new ResultSetMysql( $rs );
      else
        $rv =& $rs;
      return $rv;
    }

    public function getLastRowIdentifier() {
      $rv = @mysql_insert_id( $this->getResource() );
      if ( $rv === 0 || $rv === false )
        $rv = null;
      return $rv;
    }
  }
?>