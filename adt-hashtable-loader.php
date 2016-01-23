<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Exemple d'utilisation de l'ADT Map
   */
  require 'c.system.php';

  System::import( 'System.ADT.Hashtable' );

  $m =& new Hashtable();
  System::export( '-- adding a/Hello, b/World, c/123 --' );
  $m->put( 'a', 'Hello' );
  $m->put( 'b', 'World' );
  $m->put( 'c', 123 );
  System::export( (string)$m, 'Hashtable' );

  System::export( '-- contains key c --' );
  System::export( $m->containsKey( 'c' ) );

  System::export( '-- contains value World --' );
  System::export( $m->containsValue( 'World' ) );

  System::export( '-- removing b --' );
  $m->remove( 'b' );
  System::export( (string)$m, 'Hashtable' );

  System::export( '-- contains value World --' );
  System::export( $m->containsValue( 'World' ) );

  System::export( '-- creating Map 2 --' );
  $m2 =& new Hashtable();
  $m2->put( 1, 'Tic' );
  $m2->put( 'middle', 'Tac' );
  $m2->put( 'final', 'Toe' );
  System::export( (string)$m2, 'Hashtable 2' );

  System::export( '-- coping Map 2 elements to Map 1 --' );
  $m->putAll( $m2 );
  System::export( (string)$m, 'Hashtable' );

  System::export( '-- clear Map 2 --' );
  $m2->clear();
  System::export( (string)$m2, 'Hashtable 2' );

  System::export( '-- iterate -- ' );
  $iterator = $m->getIterator();
  while( $iterator->hasNext() ) {
    $entry =& $iterator->next();
    System::export( 'key: '.$entry->getKey().System::crlf.'value: '.(string)$entry->getValue(), 'élément n°'.$iterator->key() );
  }
?>