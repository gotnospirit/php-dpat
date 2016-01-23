<?php
  /**
   * @package       Caddy.Iterators
   * @class         CaddyItemIterator
   * @author        Jimmy CHARLEBOIS
   * @date          06-03-2007
   * @brief         Itérateur sur les propriétés d'un élément de caddy
   */
  System::import( 'System.Interfaces.Iteration.IIterator' );
  System::import( 'System.Exceptions.IllegalArgumentException' );
  System::import( 'System.Exceptions.UnsupportedOperationException' );

  class CaddyItemIterator implements IIterator {
    private $_caddy_item;
    private $_pointeur;

    public function __construct( ICaddyItem &$caddyItem ) {
      $this->_caddy_item =& $caddyItem;
      $this->_pointeur = -1;
    }

    public function __clone() {
      return new CaddyItemIterator( $this->_caddy_item );
    }

    public function hasNext() {
      return ( $this->_pointeur + 1 < $this->_caddy_item->size() );
    }

    public function key() {
      return $this->_pointeur;
    }

    public function seek( $pointeur ) {
      if ( !is_int( $pointeur ) )
        throw new IllegalArgumentException();
      if ( $pointeur < 0 && $pointeur > $this->_caddy_item->size() )
        throw new OutOfBoundsException();
      $this->_pointeur = $pointeur;
      return true;
    }

    public function &next() {
      $this->_pointeur++;
      $rv = null;
      $tmp = $this->_caddy_item->toArray();
      if ( array_key_exists( $this->_pointeur, $tmp ) )
        $rv = $tmp[ $this->_pointeur ];
      return $rv;
    }

    public function remove() {
      throw new UnsupportedOperationException();
    }
  }
?>