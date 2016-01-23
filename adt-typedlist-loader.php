<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          21-02-2007
   * @brief         Exemple d'utilisation des collections typées
   */
  require 'c.system.php';

  System::import( 'System.ADT.Scalar.String' );
  System::import( 'System.ADT.Queue' );
  System::import( 'System.ADT.TypedQueue' );
  System::import( 'System.ADT.Stack' );
  System::import( 'System.ADT.TypedStack' );

  $q =& new TypedQueue( 'String', new Queue() );
  $q->enqueue( new String( 'hello' ) );
  $q->enqueue( new String( 'world' ) );
  $q->enqueue( new String( 1 ) );
  System::export( (string)$q, 'TypedQueue' );

  $s =& new TypedStack( 'String', new Stack() );
  $s->push( new String( 'hello' ) );
  $s->push( new String( 'world' ) );
  $s->push( new String( 1 ) );
  System::export( (string)$s, 'TypedStack' );
?>