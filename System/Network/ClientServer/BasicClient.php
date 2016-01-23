<?php
  /**
   * @package       Network.ClientServer
   * @class         BasicClient
   * @author        Jimmy CHARLEBOIS
   * @date          24-04-2007
   * @brief         Impl�mentation d'un client pour AbstractServer
   */
  System::import( 'System.Network.ClientServer.AbstractClient' );

  class BasicClient extends AbstractClient {
    public function __construct( BasicServer &$server, $socket, $timeout ) {
      parent::__construct( $server, $socket, $timeout );
    }
  }
?>