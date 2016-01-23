<?php
  /**
   * @package     	ADT
   * @class       	Stack
   * @author      	Jimmy CHARLEBOIS
   * @date        	19-02-2007
   * @brief       	Implémentation d'une file d'attente du type LIFO
   * @example       adt-stack-loader.php
   */
  System::import( 'System.Interfaces.ADT.IStack' );
  System::import( 'System.ADT.AbstractList' );
  System::import( 'System.ADT.Iterators.ListIterator' );

  class Stack extends AbstractList implements IStack {
    public function __construct() {
      parent::__construct();
    }

    public function getIterator() {
      return new ListIterator( $this );
    }

    public function push( $element ) {
      array_unshift( $this->_values, $element );
    }

    public function peek() {
      if ( $this->isEmpty() )
        return null;
      return $this->_values[ 0 ];
    }

    public function pop() {
      if ( $this->isEmpty() )
        return null;
      return array_shift( $this->_values );
    }

    public function search( $element ) {
      return $this->indexOf( $element );
    }
  }
?>