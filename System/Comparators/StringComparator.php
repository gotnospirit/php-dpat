<?php
  /**
   * @package     	Comparator
   * @class       	StringComparator
   * @author      	Jimmy CHARLEBOIS
   * @date        	19-02-2007
   * @brief       	Classe permettant de comparer deux chaînes de caractères entre elles
   */
  System::import( 'System.Interfaces.Comparator.IComparator' );
  System::import( 'System.Exceptions.IllegalArgumentException' );

  class StringComparator implements IComparator {
    public function compare( IComparable $a, IComparable $b ) {
      if ( !is_a( $a, 'String' ) || !is_a( $b, 'String' ) )
        throw new IllegalArgumentException( 'Both arguments must be an instance of String object' );
      return $a->compareTo( $b );
    }
  }
?>