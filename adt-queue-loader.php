<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Exemple d'utilisation de l'ADT Queue
   */
  require 'c.system.php';

  System::import( 'System.ADT.Queue' );

  $q =& new Queue();

  System::export( '-- adding a, b, c --' );
  $q->enqueue( 'a' );
  $q->enqueue( 'b' );
  $q->enqueue( 'c' );
  System::export( (string)$q, 'Queue' );

  System::export( '-- dequeue --' );
  $q->dequeue();
  System::export( (string)$q, 'Queue' );

  System::export( '-- adding d --' );
  $q->enqueue( 'd' );
  System::export( (string)$q, 'Queue' );

  System::export( '-- peek --' );
  $element = $q->peek();
  System::export( $element );
  System::export( (string)$q, 'Queue' );

  System::export( '-- poll --' );
  $element = $q->poll();
  System::export( $element );
  System::export( (string)$q, 'Queue' );

  System::export( '-- clear --' );
  $q->clear();
  System::export( (string)$q, 'Queue' );

  System::export( '-- adding a, b, c, d --' );
  $q->enqueue( 'a' );
  $q->enqueue( 'b' );
  $q->enqueue( 'c' );
  $q->enqueue( 'd' );

  System::export( '-- iterate -- ' );
  $iterator = $q->getIterator();
  while( $iterator->hasNext() )
    System::export( $iterator->next(), 'élément n°'.$iterator->key() );
?>