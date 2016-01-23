<?php
  /**
   * @package       ADT.Iterators
   * @class         MapIterator
   * @author        Jimmy CHARLEBOIS
   * @date          21-02-2007
   * @brief         Itérateur pour collection associant clés et valeurs
   * @todo          Implémentation d'un current() et previous() ?         
   */
  System::import( 'System.Interfaces.Iteration.IDynamicIterator' );
  System::import( 'System.Exceptions.IllegalArgumentException' );
  System::import( 'System.Exceptions.UnsupportedOperationException' );

  class MapIterator implements IDynamicIterator {
    private $_map;
    private $_pointeur;

    public function __construct( IMap &$map ) {
      $this->_map =& $map;
      $this->_pointeur = -1;
    }

    public function __clone() {
      $this->_map = clone $this->_map;
      $this->rewind();
    }

    public function rewind() {
      $this->_pointeur = -1;
    }

    public function hasNext() {
      return ( $this->_pointeur + 1 < $this->_map->size() );
    }

    public function hasPrevious() {
      return ( $this->_pointeur > 0 );
    }

    public function nextIndex() {
      return ( $this->hasNext() )
        ? $this->_pointeur + 1 : null;
    }

    public function previousIndex() {
      return ( $this->hasPrevious() )
        ? $this->_pointeur - 1 : null;
    }

    public function key() {
      return $this->_pointeur;
    }

    public function seek( $pointeur ) {
      if ( !is_int( $pointeur ) )
        throw new IllegalArgumentException();
      if ( $pointeur < 0 && $pointeur > $this->_map->size() )
        throw new OutOfBoundsException();
      $this->_pointeur = $pointeur;
      return true;
    }

    public function &current() {
      $rv = null;
      $tmp = $this->_map->entrySet();
      if ( is_null( $tmp ) )
        return $rv;
      $tmp = $tmp->toArray();
/**
 * @note    01-05-2007  modification pour avoir une référence et non une copie
 */
      if ( array_key_exists( $this->_pointeur, $tmp ) )
        $rv =& $tmp[ $this->_pointeur ];
      return $rv;
    }

    public function &next() {
      $this->_pointeur++;
      $rv =& $this->current();
      return $rv;
    }

    public function &previous() {
      $this->_pointeur--;
      $rv =& $this->current();
      return $rv;
    }

    public function remove() {
      throw new UnsupportedOperationException();
    }
  }
?>