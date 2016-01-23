<?php
  /**
   * @package       Comparator
   * @class         BooleanComparator
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Classe permettant de comparer deux booléens entre eux
   */
  System::import( 'System.Interfaces.Comparator.IComparator' );
  System::import( 'System.Exceptions.IllegalArgumentException' );

  class BooleanComparator implements IComparator {
    public function compare( IComparable $a, IComparable $b ) {
      if ( !is_a( $a, 'Boolean' ) || !is_a( $b, 'Boolean' ) )
        throw new IllegalArgumentException( 'Both arguments must be an instance of Boolean object' );
      return $a->compareTo( $b );
    }
  }
?>