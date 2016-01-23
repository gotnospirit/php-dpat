<?php
  /**
   * @package       Caddy.Storage
   * @class         CaddyXmlBlobStorage
   * @author        Jimmy CHARLEBOIS
   * @date          07-03-2007
   * @brief         Classe de stockage d'objets Caddy (sous forme de blob) sur fichier xml
   */
  System::import( 'System.Caddy.Storage.CaddyStorage' );
  System::import( 'System.StoreObject' );
  System::import( 'System.Xml.xmlDocument' );

  class CaddyXmlBlobStorage extends CaddyStorage {
    public function __construct( XmlDataSource &$xml, ICaddy &$caddy = null ) {
      parent::__construct( $xml, $caddy );
    }

    public function onStorageError( IEvent &$oEvent, $args = null ) {
      //  Le document xml n'existe pas, on en crée un tout neuf
      $xml =& new xmlDocument( 'caddies' );
      $xml->toFile( $oEvent->getSource()->getDriver()->getFilepath() );
      $oEvent->getSource()->setResource( $xml );
    }

    public function &loadById( $caddyId ) {
      $xml =& $this->_storage->getResource();
      $child = $xml->getElementById( $caddyId );
      if ( !is_null( $child ) ) {
        $this->_caddy = StoreObject::restore( $child->nodeValue() );
        $this->_caddy_id = $caddyId;
        $this->_date_creation = $child->getAttribute( 'date_creation' );
        $this->_date_update = $child->getAttribute( 'date_update' );
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

      $xml =& $this->_storage->getResource();

      $root =& $xml->getDocumentElement();

      if ( is_null( $caddyId ) ) {    //  On insère
        $child =& $xml->createElement( 'caddy' );
        $child->setAttribute( 'id', $caddyId );
        $child->setAttribute( 'date_creation', $date );
        $child->setAttribute( 'date_update', $date );
        $text =& $xml->createTextNode( $blob_data );
        $child->appendChild( $text );
        $root->appendChild( $child );

        $this->_date_creation = $this->_date_update = $date;
      } else {
        $child = $xml->getElementById( $caddyId );
        if ( !is_null( $child ) ) { //  On update
          $child->setAttribute( 'date_update', $date );
          if ( $child->hasChildNodes() )
            $child->removeChild( $child->firstChild() );
          $text =& $xml->createTextNode( $blob_data );
          $child->appendChild( $text );

          $this->_date_update = $date;
        } else {                    //  On insère
          $child =& $xml->createElement( 'caddy' );
          $child->setAttribute( 'id', $caddyId );
          $child->setAttribute( 'date_creation', $date );
          $child->setAttribute( 'date_update', $date );
          $text =& $xml->createTextNode( $blob_data );
          $child->appendChild( $text );
          $root->appendChild( $child );

          $this->_date_creation = $this->_date_update = $date;
        }
      }
      return $xml->toFile( $this->_storage->getDriver()->getFilepath() );
    }

    public function delete( $caddyId ) {
      $xml =& $this->_storage->getResource();
      $child = $xml->getElementById( $caddyId );
      if ( is_null( $child ) )
        return false;
      else {
        $child->parentNode()->removeChild( $child );
        return $xml->toFile( $this->_storage->getDriver()->getFilepath() );
      }
    }
  }
?>