<?php
  /**
   * @package       ADT.Scalar
   * @class         Date
   * @author        Jimmy CHARLEBOIS
   * @date          21-02-2007
   * @brief         Implémentation de l'ADT date
   */
  System::import( 'System.ADT.AbstractScalar' );
  System::import( 'System.Exceptions.IllegalArgumentException' );

  class Date extends AbstractScalar {
    public function __construct( $year, $month, $day ) {
      if ( !is_int( $year ) || !is_int( $month ) || !is_int( $day ) )
        throw new IllegalArgumentException( 'Arguments must be integer' );
      if ( !checkdate ( $month, $day, $year ) )
        throw new RangeException( 'Invalid date' );
      parent::__construct( System::implode( $year, str_pad( $month, 2, '0', STR_PAD_LEFT ), str_pad( $day, 2, '0', STR_PAD_LEFT ), '-' ) );
    }

    public function compareTo( IComparable $o ) {
      if ( !is_a( $o, 'Date' ) )
        throw new IllegalArgumentException( 'Argument must be an instance of Date object' );
      return parent::compareTo( $o );
    }

    public function __toString() {
      return $this->getValue();
    }
  }
?>