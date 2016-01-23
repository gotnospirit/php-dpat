<?php
  /**
   * @package       ADT
   * @class         TypedStack
   * @author        Jimmy CHARLEBOIS
   * @date          21-02-2007
   * @brief         Classe concrête pour collection de valeurs typées de type LIFO
   */
  System::import( 'System.Interfaces.ADT.IStack' );
  System::import( 'System.ADT.AbstractTypedList' );

  class TypedStack extends AbstractTypedList implements IStack {
    public function __construct( $type, IStack &$stack ) {
      parent::__construct( $type, $stack );
    }

    public function push( $element ) {
      if ( !is_a( $element, $this->_type ) )
        throw new TypeMismatchException( sprintf( 'Argument must be an instance of %s object', $this->_type ) );
      return $this->_collection->push( $element );
    }

    public function peek() {
      return $this->_collection->peek();
    }

    public function pop() {
      return $this->_collection->pop();
    }

    public function search( $element ) {
      if ( !is_a( $element, $this->_type ) )
        throw new TypeMismatchException( sprintf( 'Argument must be an instance of %s object', $this->_type ) );
      return $this->_collection->search( $element );
    }
  }
?>