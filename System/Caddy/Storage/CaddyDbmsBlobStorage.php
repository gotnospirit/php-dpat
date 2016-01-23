<?php
  /**
   * @package     	Caddy.Storage
   * @class       	CaddyDbmsBlobStorage
   * @author      	Jimmy CHARLEBOIS
   * @date        	07-03-2007
   * @brief       	Classe de stockage d'objets Caddy (sous forme de blob) sur Dbms
   */
  System::import( 'System.Caddy.Storage.CaddyStorage' );
  System::import( 'System.SqlBuilder.SqlBuilder' );
  System::import( 'System.StoreObject' );

  class CaddyDbmsBlobStorage extends CaddyStorage {
    public function __construct( DbmsDataSource &$db, ICaddy &$caddy = null ) {
      parent::__construct( $db, $caddy );
    }

    public function onStorageError( IEvent &$oEvent, $args = null )
    {}

    public function &loadById( $caddyId ) {
      $sql =& new sqlBuilder();
      $alias = $sql->aliasTable( 'Caddy', 'c' );
      $sql->get( $alias, 'date_creation' );
      $sql->get( $alias, 'date_update' );
      $sql->get( $alias, 'blob_caddy' );
      $sql->whereField( $alias, 'id_caddy', $caddyId, '=', sqlBuilder::AndOperator );

      if ( $rs =& $this->_storage->execute( $sql->select() ) )
        if( $rs->hasNext() ) {
          $row =& $rs->next();
          $this->_caddy = StoreObject::restore( $row[ 'blob_caddy' ] );
          $this->_caddy_id = $caddyId;
          $this->_date_creation = $row[ 'date_creation' ];
          $this->_date_update = $row[ 'date_update' ];
          $rs->dispose();
        } else {
          $this->_caddy = null;
        }

      return $this->_caddy;
    }

    public function save( &$caddyId = null ) {
      $rv = false;
      if ( is_null( $this->_caddy ) )
        throw new Exception( 'No caddy to save' );
      if ( is_null( $caddyId ) )
        $caddyId = $this->_caddy_id;

      $blob_data = StoreObject::store( $this->_caddy );
      $date = date( 'Y-m-d H:i:s' );

      $sql =& new sqlBuilder();
      if ( is_null( $caddyId ) ) {    //  On insère
        $sql->set( 'date_creation', $date, sqlBuilder::SqlTypeDate );
        $sql->set( 'date_update', $date, sqlBuilder::SqlTypeDate );
        $sql->set( 'blob_caddy', $blob_data, sqlBuilder::SqlTypeString );
        $rv = $this->_storage->execute( $sql->insert( 'Caddy' ) );
        if ( $rv ) {
          $this->_caddy_id = $this->_storage->getLastRowIdentifier();
          $this->_date_creation = $this->_date_update = $date;
        }
      } else {
        $alias = $sql->aliasTable( 'Caddy', 'c' );
        $sql->get( $alias, 'date_creation' );
        $sql->whereField( $alias, 'id_caddy', $caddyId, '=', sqlBuilder::AndOperator );
        if ( $rs =& $this->_storage->execute( $sql->select() ) ) {
          $sql->reset();
          if ( $rs->hasNext() ) {   //  On update
            $rs->dispose();
            $alias = $sql->aliasTable( 'Caddy', 'c' );
            $sql->set( 'date_update', $date, sqlBuilder::SqlTypeDate );
            $sql->set( 'blob_caddy', $blob_data, sqlBuilder::SqlTypeString );
            $sql->whereField( $alias, 'id_caddy', $caddyId, '=', sqlBuilder::AndOperator );
            $rv = $this->_storage->execute( $sql->update( $alias ) );
            if ( $rv )
              $this->_date_update = $date;
          } else {                  //  On insère
            $sql->set( 'date_creation', $date, sqlBuilder::SqlTypeDate );
            $sql->set( 'date_update', $date, sqlBuilder::SqlTypeDate );
            $sql->set( 'blob_caddy', $blob_data, sqlBuilder::SqlTypeString );
            $rv = $this->_storage->execute( $sql->insert( 'Caddy' ) );
            if ( $rv ) {
              $this->_caddy_id = $this->_storage->getLastRowIdentifier();
              $this->_date_creation = $this->_date_update = $date;
            }
          }
        }
      }
      return $rv;
    }

    public function delete( $caddyId ) {
      $sql =& new sqlBuilder();
      $alias = $sql->aliasTable( 'Caddy', 'c' );
      $sql->whereField( $alias, 'id_caddy', $caddyId, '=', sqlBuilder::AndOperator );
      if ( $this->_storage->execute( $sql->delete( $alias ) ) ) {
        $this->_caddy = null;
        $this->_caddy_id = null;
        $this->_date_update = null;
        $this->_date_creation = null;
        return true;
      }
      return false;
    }
  }
?>