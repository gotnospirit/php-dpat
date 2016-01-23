<?php
  /**
   * @package       ADT.Scalar
   * @class         String
   * @author        Jimmy CHARLEBOIS
   * @date          21-02-2007
   * @brief         Implémentation de l'ADT chaîne de caractères
   */
  System::import( 'System.ADT.AbstractScalar' );
  System::import( 'System.Exceptions.IllegalArgumentException' );

  class String extends AbstractScalar {
    public function __construct( $value ) {
      if ( !is_scalar( $value ) )
        throw new IllegalArgumentException( 'Argument must be scalar' );
      parent::__construct( (string)$value );
    }

    public function compareTo( IComparable $o ) {
      if ( !is_a( $o, 'String' ) )
        throw new IllegalArgumentException( 'Argument must be an instance of String object' );
      return parent::compareTo( $o );
    }

    public function __toString() {
      return $this->getValue();
    }
  }
?>