<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          14-02-2007
   * @brief         Exemple d'envoi d'une requ�te Http
   */
  require 'c.system.php';

  System::import( 'System.Network.HttpRequest' );

  $http =& new HttpRequest( 'http://localhost/httprequest-remote-sample.php', HttpMessage::METHOD_POST );
  $http->setQueryString(
    array(
      'msgcontent' => 'Hello world !'
    )
  );
  $httpResponse =& $http->send();
  if ( !is_null( $httpResponse ) ) {
    if ( $httpResponse->getResponseCode() == 200 ) {
      echo nl2br( htmlspecialchars( $httpResponse->getBody() ) );
    } else {
      echo "Requ�te:\r\n";
      var_dump( (string)$http );
      echo "R�ponse:\r\n";
      var_dump( (string)$httpResponse );
    }
  }
?>