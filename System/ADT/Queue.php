<?php
  /**
   * @package     	ADT
   * @class       	Queue
   * @author      	Jimmy CHARLEBOIS
   * @date        	19-02-2007
   * @brief       	Implémentation d'une file d'attente du type FIFO
   * @example       adt-queue-loader.php
   */
  System::import( 'System.Interfaces.ADT.IQueue' );
  System::import( 'System.ADT.AbstractList' );
  System::import( 'System.ADT.Iterators.ListIterator' );

  class Queue extends AbstractList implements IQueue {
    public function __construct() {
      parent::__construct();
    }

    public function getIterator() {
      return new ListIterator( $this );
    }

    public function dequeue() {
      if ( $this->isEmpty() )
        return false;
      array_shift( $this->_values );
      return true;
    }

    public function enqueue( $element ) {
      array_push( $this->_values, $element );
    }

    public function peek() {
      if ( $this->isEmpty() )
        return null;
      return $this->_values[ 0 ];
    }

    public function poll() {
      if ( $this->isEmpty() )
        return null;
      return array_shift( $this->_values );
    }
  }
?>