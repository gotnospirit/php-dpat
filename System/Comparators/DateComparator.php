<?php
  /**
   * @package       Comparator
   * @class         DateComparator
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Classe permettant de comparer deux dates entre eux
   */
  System::import( 'System.Interfaces.Comparator.IComparator' );

  class DateComparator implements IComparator {
    public function compare( IComparable $a, IComparable $b ) {
      if ( !is_a( $a, 'Date' ) || !is_a( $b, 'Date' ) )
        throw new IllegalArgumentException( 'Both arguments must be an instance of Date object' );
      return $a->compareTo( $b );
    }
  }
?>