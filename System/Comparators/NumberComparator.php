<?php
  /**
   * @package       Comparator
   * @class         NumberComparator
   * @author        Jimmy CHARLEBOIS
   * @date          23-02-2007
   * @brief         Classe permettant de comparer deux nombres entre eux
   */
  System::import( 'System.Interfaces.Comparator.IComparator' );
  System::import( 'System.Exceptions.IllegalArgumentException' );

  class NumberComparator implements IComparator {
    public function compare( IComparable $a, IComparable $b ) {
      if ( !is_a( $a, 'Number' ) || !is_a( $b, 'Number' ) )
        throw new IllegalArgumentException( 'Both arguments must be an instance of Number object' );
      return $a->compareTo( $b );
    }
  }
?>