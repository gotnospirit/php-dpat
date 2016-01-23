<?php
  /**
   * @package       ADT.Iterators
   * @class         AbstractCollectionIterator
   * @author        Jimmy CHARLEBOIS
   * @date          21-02-2007
   * @brief         Classe abstraire pour iterateur de collection
   */
  System::import( 'System.Interfaces.Iteration.IDynamicIterator' );
  System::import( 'System.Exceptions.IllegalArgumentException' );

  abstract class AbstractCollectionIterator implements IDynamicIterator {
    private $_collection;
    private $_pointeur;

    public function __construct( ICollection &$collection ) {
      $this->_collection =& $collection;
      $this->_pointeur = -1;
    }

    public function __clone() {
      $this->_collection = clone $this->_collection;
      $this->rewind();
    }

    public function rewind() {
      $this->_pointeur = -1;
    }

    public function hasNext() {
      return ( $this->_pointeur + 1 < $this->_collection->size() );
    }

    public function nextIndex() {
      return ( $this->hasNext() )
        ? $this->_pointeur + 1 : null;
    }

    public function hasPrevious() {
      return ( $this->_pointeur > 0 );
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
      if ( $pointeur < 0 && $pointeur > $this->_collection->size() )
        throw new OutOfBoundsException();
      $this->_pointeur = $pointeur;
      return true;
    }
/*
    public function set( $o );
*/
    /**
     * @brief   Retourne la collection associée à l'itérateur
     * @return  ICollection
     */
    public function &getCollection() {
      return $this->_collection;
    }

    /**
     * @brief   Retourne le pointeur interne de l'itérateur
     * @return  integer
     */
    protected function getPointeur() {
      return $this->_pointeur;
    }

    /**
     * @brief   Définit la position du pointeur interne de l'itérateur
     * @return  void
     */
    protected function setPointeur( $pointeur ) {
      if ( !is_int( $pointeur ) )
        throw new IllegalArgumentException();
      $this->_pointeur = $pointeur;
    }
  }
?>