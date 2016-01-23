<?php
  /**
   * @package       ADT.Iterators
   * @class         SetIterator
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Itérateur pour collection de valeurs
   */
  System::import( 'System.ADT.Iterators.AbstractCollectionIterator' );
  System::import( 'System.Exceptions.UnsupportedOperationException' );

  class SetIterator extends AbstractCollectionIterator {
    public function __construct( ISet &$collection ) {
      parent::__construct( $collection );
    }

    public function &current() {
      $rv = null;
      $p = $this->getPointeur();
      $tmp = $this->getCollection()->toArray();
/**
 * @note    01-05-2007  modification pour avoir une référence et non une copie
 */
      if ( array_key_exists( $p, $tmp ) )
        $rv =& $tmp[ $p ];
      return $rv;
    }

    public function &next() {
      $this->setPointeur( $this->getPointeur() + 1 );
      $rv =& $this->current();
      return $rv;
    }

    public function &previous() {
      $this->setPointeur( $this->getPointeur() - 1 );
      $rv =& $this->current();
      return $rv;
    }

    public function remove() {
      throw new UnsupportedOperationException();
    }
  }
?>