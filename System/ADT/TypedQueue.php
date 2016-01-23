<?php
  /**
   * @package     	ADT
   * @class       	TypedQueue
   * @author      	Jimmy CHARLEBOIS
   * @date        	21-02-2007
   * @brief       	Classe concrête pour collection de valeurs typées de type FIFO
   */
  System::import( 'System.Interfaces.ADT.IQueue' );
  System::import( 'System.ADT.AbstractTypedList' );

  class TypedQueue extends AbstractTypedList implements IQueue {
    public function __construct( $type, IQueue &$queue ) {
      parent::__construct( $type, $queue );
    }

    public function dequeue() {
      return $this->_collection->dequeue();
    }

    public function enqueue( $element ) {
      if ( !is_a( $element, $this->_type ) )
        throw new TypeMismatchException( sprintf( 'Argument must be an instance of %s object', $this->_type ) );
      $this->_collection->enqueue( $element );
    }

    public function peek() {
      return $this->_collection->peek();
    }

    public function poll() {
      return $this->_collection->poll();
    }
  }
?>