<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Exemple d'utilisation de l'ADT Stack
   */
  require 'c.system.php';

  System::import( 'System.ADT.Stack' );

  $s =& new Stack();

  System::export( '-- adding a, b, c, a --' );
  $s->push( 'a' );
  $s->push( 'b' );
  $s->push( 'c' );
  $s->push( 'a' );
  System::export( (string)$s, 'Stack' );

  System::export( '-- pop --' );
  $s->pop();
  System::export( (string)$s, 'Stack' );

  System::export( '-- adding d --' );
  $s->push( 'd' );
  System::export( (string)$s, 'Stack' );

  System::export( '-- peek --' );
  $element = $s->peek();
  System::export( $element );
  System::export( (string)$s, 'Stack' );

  System::export( '-- pop --' );
  $element = $s->pop();
  System::export( $element );
  System::export( (string)$s, 'Stack' );

  System::export( '-- clear --' );
  $s->clear();
  System::export( (string)$s, 'Stack' );

  System::export( '-- adding a, b, c, d --' );
  $s->push( 'a' );
  $s->push( 'b' );
  $s->push( 'c' );
  $s->push( 'd' );

  System::export( '-- index of c --' );
  System::export( $s->search( 'c' ) );

  System::export( '-- iterate -- ' );
  $iterator = $s->getIterator();
  while( $iterator->hasNext() ) {
    System::export( $iterator->next(), 'élément n°'.$iterator->key() );
  }
?>