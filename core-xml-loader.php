<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          08-03-2007
   * @brief         Exemple d'utilisation de la classe xmlDocument
   */
  require 'c.system.php';

  System::import( 'System.Xml.xmlDocument' );

//  System::export( '-- creating xml document --' );
  $xml =& new xmlDocument( 'root' );
  $xml->setEncoding( 'windows-1252' );
//  System::export( htmlspecialchars( (string)$xml ), 'xml' );

  $root =& $xml->getDocumentElement();

//  System::export( '-- adding a user --' );

  $user =& $xml->createElement( 'user' );
  $user->setAttribute( 'firstname', 'James' );
  $user->setAttribute( 'lastname', 'Pota"gueule' );
  $user->setAttribute( 'birthday', date( 'Y-m-d' ) );
  $user->appendChild( $xml->createTextNode( 'É<wè Lor>en ip\'sum...' ) );
  $root->appendChild( $user );

//  System::export( htmlspecialchars( (string)$xml ), 'xml' );
  Header( 'Content-Type: text/xml; charset="windows-1252"' );
  echo (string)$xml;
?>