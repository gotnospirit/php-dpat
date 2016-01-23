<?php
  /**
   * @package     	ADT.Scalar
   * @class       	Boolean
   * @author      	Jimmy CHARLEBOIS
   * @date        	21-02-2007
   * @brief       	Implémentation de l'ADT booléen
   */
  System::import( 'System.ADT.AbstractScalar' );
  System::import( 'System.Exceptions.IllegalArgumentException' );

  class Boolean extends AbstractScalar {
    public function __construct( $value ) {
      if ( is_int( $value ) ) {
        if ( $value != 0 && $value != 1 )
          throw new IllegalArgumentException( 'Only 0 or 1 values are permitted' );
      } elseif ( !is_bool( $value ) ) {
        throw new IllegalArgumentException();
      }
      parent::__construct( (int)$value );
    }

    public function compareTo( IComparable $o ) {
      if ( !is_a( $o, 'Boolean' ) )
        throw new IllegalArgumentException( 'Argument must be an instance of Boolean object' );
      return parent::compareTo( $o );
    }

    public function __toString() {
      return ( 1 == $this->getValue() )
        ? 'true'
        : 'false';
    }
  }
?>