<?php
  /**
   * @package       ADT.Scalar
   * @class         Number
   * @author        Jimmy CHARLEBOIS
   * @date          23-02-2007
   * @brief         Implémentation de l'ADT nombre
   */
  System::import( 'System.ADT.AbstractScalar' );
  System::import( 'System.Exceptions.IllegalArgumentException' );

  class Number extends AbstractScalar {
    public function __construct( $value ) {
      if ( !is_numeric( $value ) )
        throw new IllegalArgumentException( 'Argument must be numeric' );
      parent::__construct( (float)$value );
    }

    public function compareTo( IComparable $o ) {
      if ( !is_a( $o, 'Number' ) )
        throw new IllegalArgumentException( 'Argument must be an instance of Number object' );
      return parent::compareTo( $o );
    }

    public function __toString() {
      return (string)$this->getValue();
    }
  }
?>