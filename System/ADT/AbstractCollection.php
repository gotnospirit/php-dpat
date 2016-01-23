<?php
  /**
   * @package       ADT
   * @class         AbstractCollection
   * @author        Jimmy CHARLEBOIS
   * @date          21-02-2007
   * @brief         Classe abstraite pour les collections
   */
  System::import( 'System.Interfaces.ADT.IADT' );
  System::import( 'System.Interfaces.ADT.ICollection' );

  abstract class AbstractCollection implements IADT, ICollection {
    protected $_values;

    protected function __construct() {
      $this->_values = array();
    }

    public function __toString() {
      $rv = '[';
      if ( !$this->isEmpty() ) {
        foreach( $this->_values AS $idx => $value )
          $rv .= (string)$value.',';
        $rv = substr( $rv, 0, -1 );
      }
      $rv .= ']';
      return $rv;
    }

    public function clear() {
      $this->_values = array();
    }

    public function size() {
      return count( $this->_values );
    }

    public function isEmpty() {
      return $this->size() == 0;
    }

    public function toString() {
      return (string)$this;
    }

    public function toArray() {
      return $this->_values;
    }

    public function add( $o ) {
      $this->_values[] =& $o;
      return true;
    }

    public function addAll( ICollection $collection ) {
      $iterator = $collection->getIterator();
      while( $iterator->hasNext() )
        $this->add( $iterator->next() );
      return true;
    }

    public function contains( $o ) {
      return in_array( $o, $this->_values );
    }

    public function containsAll( ICollection $collection ) {
      $rv = true;
      $iterator = $collection->getIterator();
      while( $iterator->hasNext() )
        if ( !$this->contains( $iterator->next() ) ) {
          $rv = false;
          break;
        }
      return $rv;
    }

    public function remove( $o ) {
      $rv = false;
      foreach( $this->_values AS $idx => $value )
        if ( $o == $value ) {
          unset( $this->_values[ $idx ] );
          $rv = true;
          break;
        }
      return $rv;
    }

    public function removeAll( ICollection $collection ) {
      $rv = true;
      $iterator = $collection->getIterator();
      while( $iterator->hasNext() )
        if ( !$this->remove( $iterator->next() ) ) {
          $rv = false;
          break;
        }
      return $rv;
    }
  }
?>