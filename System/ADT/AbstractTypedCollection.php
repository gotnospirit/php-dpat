<?php
  /**
   * @package     	ADT
   * @class       	AbstractTypedCollection
   * @author      	Jimmy CHARLEBOIS
   * @date        	21-02-2007
   * @brief       	Classe abstraite pour gérer des collections avec des éléments typés
   */
  System::import( 'System.Interfaces.ADT.IADT' );
  System::import( 'System.Interfaces.ADT.ICollection' );
  System::import( 'System.Exceptions.TypeMismatchException' );

  abstract class AbstractTypedCollection implements IADT, ICollection {
    protected $_collection;
    protected $_type;

    protected function __construct( $type, ICollection &$collection ) {
      $this->_collection =& $collection;
      $this->_type = $type;
    }

    public function __toString() {
      return (string)$this->_collection;
    }

    public function clear() {
      $this->_collection->clear();
    }

    public function size() {
      return $this->_collection->size();
    }

    public function isEmpty() {
      return $this->_collection->isEmpty();
    }

    public function toString() {
      return (string)$this;
    }

    public function toArray() {
      return $this->_collection->toArray();
    }

    public function add( $o ) {
      if ( !is_a( $o, $this->_type ) )
        throw new TypeMismatchException( sprintf( 'Argument must be an instance of %s object', $this->_type ) );
      return $this->_collection->add( $o );
    }

    public function addAll( ICollection $collection ) {
      $iterator = $collection->getIterator();
      while( $iterator->hasNext() )
        $this->add( $iterator->next() );
      return true;
    }

    public function contains( $o ) {
      if ( !is_a( $o, $this->_type ) )
        throw new TypeMismatchException( sprintf( 'Argument must be an instance of %s object', $this->_type ) );
      return $this->_collection->contains( $o );
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
      if ( !is_a( $o, $this->_type ) )
        throw new TypeMismatchException( sprintf( 'Argument must be an instance of %s object', $this->_type ) );
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

    public function getIterator() {
      return $this->_collection->getIterator();
    }
  }
?>