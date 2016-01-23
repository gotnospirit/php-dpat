<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          11-04-2007
   * @brief         Exemple d'utilisation des cookies
   */
  require_once 'c.system.php';

  System::import( 'System.Context.HttpContext' );
  System::import( 'System.Session.CookieSession' );

  $context =& new HttpContext();

  if ( $context->hasParam( 'delete' ) ) {
    System::export( '-- Delete cookie --' );
    System::export( CookieSession::delete( 'ValeurDeTest' ) );
  }

  //  Même s'il implémente l'interface ISession, on ne démarre pas CookieSession -> UnsupportedOperationException
  //CookieSession::start();

  System::export( '-- Retrieve cookie value --' );
  $test_value = CookieSession::get( 'ValeurDeTest' );
  System::export( $test_value );

  System::export( '-- Storing cookie value --' );
  System::export( CookieSession::set( 'ValeurDeTest', 'ma valeur qui va bien' ) );

  echo '<a href="?delete=1">delete cookie</a>';
?>