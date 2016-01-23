<?php
  /**
   * @package     	Caddy.Iterators
   * @class       	CaddyIterator
   * @author      	Jimmy CHARLEBOIS
   * @date        	06-03-2007
   * @brief       	Itérateur sur les éléments d'un caddy
   */
  System::import( 'System.Interfaces.Iteration.IIterator' );
  System::import( 'System.Exceptions.IllegalArgumentException' );
  System::import( 'System.Exceptions.UnsupportedOperationException' );

  class CaddyIterator implements IIterator {
    private $_caddy;
    private $_pointeur;

    public function __construct( ICaddy &$caddy ) {
      $this->_caddy =& $caddy;
      $this->_pointeur = -1;
    }

    public function __clone() {
      return new CaddyItemIterator( $this->_caddy_item );
    }

    public function hasNext() {
      return ( $this->_pointeur + 1 < $this->_caddy->size() );
    }

    public function key() {
      return $this->_pointeur;
    }

    public function seek( $pointeur ) {
      if ( !is_int( $pointeur ) )
        throw new IllegalArgumentException();
      if ( $pointeur < 0 && $pointeur > $this->_caddy->size() )
        throw new OutOfBoundsException();
      $this->_pointeur = $pointeur;
      return true;
    }

    public function &next() {
      $this->_pointeur++;
      $rv = null;
      $tmp = $this->_caddy->toArray();
      if ( array_key_exists( $this->_pointeur, $tmp ) )
        $rv = $tmp[ $this->_pointeur ];
      return $rv;
    }

    public function remove() {
      throw new UnsupportedOperationException();
    }
  }
?>