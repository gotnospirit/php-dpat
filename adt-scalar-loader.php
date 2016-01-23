<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          21-02-2007
   * @brief         Exemple d'utilisation des ADT Scalar
   */
  require 'c.system.php';

  System::import( 'System.ADT.Scalar.Boolean' );
  System::import( 'System.Comparators.BooleanComparator' );
  System::import( 'System.ADT.Scalar.String' );
  System::import( 'System.Comparators.StringComparator' );
  System::import( 'System.ADT.Scalar.Date' );
  System::import( 'System.Comparators.DateComparator' );

  System::export( '-- Boolean --' );
  $b1 =& new Boolean( true );
  $b2 =& new Boolean( 0 );

  System::export( (string)$b1, 'b1' );
  System::export( (string)$b2, 'b2' );

  $comparator =& new BooleanComparator();
  System::export( $comparator->compare( $b1, $b2 ), '-- compare b1 & b2 --' );
  System::export( $comparator->compare( $b2, $b1 ), '-- compare b2 & b1 --' );

  System::export( '-- String --' );
  $s1 =& new String( 'a' );
  $s2 =& new String( 'A' );
  $s3 =& new String( 'B' );

  System::export( (string)$s1, 's1' );
  System::export( (string)$s2, 's2' );
  System::export( (string)$s3, 's3' );

  $comparator =& new StringComparator();
  System::export( $comparator->compare( $s1, $s2 ), '-- compare s1 & s2 --' );
  System::export( $comparator->compare( $s2, $s3 ), '-- compare s2 & s3 --' );
  System::export( $comparator->compare( $s1, $s3 ), '-- compare s1 & s3 --' );

  System::export( '-- Date --' );
  $d1 =& new Date( 2007, 2, 1 );
  $d2 =& new Date( 2007, 1, 10 );

  System::export( (string)$d1, 'd1' );
  System::export( (string)$d2, 'd2' );

  $comparator =& new DateComparator();
  System::export( $comparator->compare( $d1, $d2 ), '-- compare d1 & d2 --' );
  System::export( $comparator->compare( $d2, $d1 ), '-- compare d2 & d1 --' );
?>