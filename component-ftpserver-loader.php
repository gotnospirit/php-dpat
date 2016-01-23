<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          24-04-2007
   * @brief         
   */
  require 'c.system.php';

  define( 'SERVER_PORT', 8000, true );
  define( 'SERVER_TIMEOUT', 30, true );
  define( 'CLIENT_TIMEOUT', 10, true );
  define( 'MAX_CONNECTIONS', 5, true );

  System::import( 'System.Network.ClientServer.FTP.FTPProxy' );

  $server =& new FTPProxy( SERVER_PORT, SERVER_TIMEOUT, MAX_CONNECTIONS );
  $server->start();
?>