<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          06-03-2007
   * @brief         Exemple du composant Caddy
   */
  require_once 'c.system.php';

  System::import( 'System.Caddy.Models.Caddy' );
  System::import( 'System.Caddy.Models.CaddyItem' );
  System::import( 'System.Caddy.Models.CaddyItemFeature' );

  System::import( 'System.DataSource.DbmsDataSource' );
  System::import( 'System.DataSource.DataSourceDriver' );

  System::import( 'System.Caddy.Storage.CaddyDbmsBlobStorage' );

  $caddy =& new Caddy();

  System::export( '-- adding "101-AFK" product --' );
  $caddy->addCaddyItem( new CaddyItem( '101-AFK', 10, 1.33 ) );
  System::export( $caddy, 'Caddy' );

  System::export( '-- update "101-AFK" quantity to 5 --' );
  $i =& $caddy->getCaddyItem( '101-AFK' );
  $i->setQuantity( 5 );

  System::export( '-- adding features to "101-AFK" product --' );
  $i->addCaddyItemFeature( new CaddyItemFeature( 'couleur', 'Vert' ) );
  $i->addCaddyItemFeature( new CaddyItemFeature( 'taille', 'XL' ) );

  System::export( '-- adding "AZERTY" product --' );
  $caddy->addCaddyItem( new CaddyItem( 'AZERTY', 1, 0 ) );

  $db =& DbmsDataSource::getInstance( DataSourceDriver::createNew( 'mysql://mysql:user@localhost.DPat/' ) );
  $db->connect();

  $s =& new CaddyDbmsBlobStorage( $db, $caddy );
  $caddyId =& $s->getCaddyId();
  if ( is_null( $caddyId ) )
    $caddyId = 1;

System::export( $caddyId, '-- Caddy ID --' );

System::export( $s->save( $caddyId ), '-- Save caddy to DBMS --' );

System::export( $caddyId, '-- Caddy ID --' );
/*
System::export( $s->delete( $caddyId ), '-- Delete caddy --' );
*/
  $caddy =& $s->loadById( $caddyId );
  if ( is_null( $caddy ) )
    $caddy =& new Caddy();
  System::export( $s->getDateUpdate(), '-- Last update time --' );

  $t =& new CaddyItem( 'AZERTY', 1, 0 );
  $caddy->removeCaddyItem( $t );

  $s->save();

  $db->dispose();

  System::export( '-- saving to caddies.xml --' );

  System::import( 'System.DataSource.XmlDataSource' );
  System::import( 'System.Caddy.Storage.CaddyXmlBlobStorage' );
  $xml =& new XmlDataSource( DataSourceDriver::createNew( 'xml://caddies.xml/' ) );
  $s =& new CaddyXmlBlobStorage( $xml, $caddy );
  $xml->connect();

  System::export( $s->save( $caddyId ) );

  $caddy =& $s->loadById( $caddyId );
  if ( is_null( $caddy ) )
    $caddy =& new Caddy();

  $xml->dispose();

  System::export( $caddy->size(), '-- caddy\' size --' );

  System::export( '-- iterate items --' );
  $iterator =& $caddy->getIterator();
  while( $iterator->hasNext() ) {
    $caddyItem =& $iterator->next();
    System::export( $caddyItem, 'élément n°'.$iterator->key() );

    $featIterator =& $caddyItem->getIterator();
    while( $featIterator->hasNext() ) {
      System::export( $featIterator->next(), 'feat n°'.$featIterator->key() );
    }
  }
?>