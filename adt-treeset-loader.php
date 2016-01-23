<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Exemple d'utilisation de l'ADT SortedSet
   */
  require_once 'c.system.php';

  System::import( 'System.ADT.TreeSet' );
  System::import( 'System.ADT.Scalar.Number' );
  System::import( 'System.Comparators.NumberComparator' );

  $tmp = array( 30,3,0,10,6,12,8 );

  $s =& new TreeSet( new NumberComparator() );
  foreach( $tmp AS $idx => $value )
    $s->add( new Number( $value ) );
  System::export( (string)$s, 'TreeSet' );

  System::export( $s->first(), '-- first --' );
  System::export( $s->last(), '-- last --' );
/*
  System::export( '-- iterate --' );
  $iterator =& $s->getIterator();
  while( $iterator->hasNext() )
    System::export( $iterator->next() );
*/
?>