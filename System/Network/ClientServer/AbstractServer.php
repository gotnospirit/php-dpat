<?php
  /**
   * @package       Network.ClientServer
   * @class         AbstractServer
   * @author        Jimmy CHARLEBOIS
   * @date          23-04-2007
   * @brief         Classe abstraite servant de socle à l'implémentation d'un serveur
   */
  System::import( 'System.Interfaces.Network.ClientServer.IServer' );
  System::import( 'System.Event.EventDispatcher' );
  System::import( 'System.Event.Event' );

  abstract class AbstractServer extends EventDispatcher implements IServer {
    private $_address;
    private $_port;
    private $_timeout;
    private $_last_time;
    private $_max_connection;

    private $_socket;
    private $_clients;

    public function __construct( $port, $timeout, $max_connection ) {
      parent::__construct();

      $this->_address = null;
      $this->_port = $port;
      $this->_timeout = $timeout;
      $this->_max_connection = $max_connection;

      $this->_last_time = time();

      $this->_socket = null;
      $this->_clients = array();
    }

    public function __destruct() {
      $this->dispose();
    }

    public function __toString() {
      return '['.get_class( $this ).'] '.$this->_address.':'.$this->_port;
    }

    public function getAddress() {
      return $this->_address;
    }
    public function getPort() {
      return $this->_port;
    }
    public function keepAlive() {
      $this->_last_time = time();
    }
    public function isTimeout() {
      if ( is_null( $this->_timeout ) )
        return false;
      $rv = ( time() - $this->_last_time ) > $this->_timeout;
      if ( $rv ) {
        $e =& new Event( 'timeout', $this, 'Le serveur en a marre d\'attendre' );
        $this->dispatch( $e );
      }
      return $rv;
    }

    public function dispose() {
      if ( is_null( $this->_socket ) || $this->_socket === false )
        return true;

      $e =& new Event( 'beforeClose', $this, 'Le serveur va être arrêté...' );
      $this->dispatch( $e );

      foreach( $this->_clients AS $uid => $client )
        $this->removeClient( $this->_clients[ $uid ] );

      @socket_shutdown( $this->_socket, 2 );
      socket_close( $this->_socket );
      $this->_socket = null;

      $e =& new Event( 'close', $this, 'Le serveur est arrêté.' );
      $this->dispatch( $e );

      $this->removeAllEventListeners();
    }

    public function start() {
      $serverHost = $serverPort = null;
      $serverSocket = @socket_create_listen( $this->_port, $this->_max_connection );
      if ( $serverSocket !== false ) {
        socket_set_nonblock( $serverSocket );
        if( socket_getsockname( $serverSocket, $serverHost, $serverPort ) ) {
          $this->_address = $serverHost;
          if ( $serverPort != $this->_port )
            $this->_port = $serverPort;
          $this->_socket =& $serverSocket;

          $e =& new Event( 'start', $this, 'Le serveur est démarré' );
          $this->dispatch( $e );

          $this->_listen();
        }
      } else {
        $e =& new Event( 'error', $this, sprintf( 'Impossible d\'ouvrir une socket sur le port %s', $this->_port ) );
        $this->dispatch( $e );
      }
    }

    public function stop() {
      $this->dispose();
    }

    /**
     * @brief   Ajoute un client à la liste du serveur
     * @param   $client   IClient    un objet encapsulant la socket du client
     * @return  void
     */
    public function bindClient( IClient &$client ) {
      $uid = md5( uniqid( rand() ) );
      while( array_key_exists( $uid, $this->_clients ) )
        $uid = md5( uniqid( rand() ) );

      $client->setUID( $uid );
      $this->_clients[ $uid ] =& $client;
    }

    /**
     * @brief   Supprime un client
     * @param   $client   Client   le client à supprimer
     * @return  void
     */
    public function removeClient( &$client ) {
      foreach( $this->_clients AS $uid => $c )
        if ( $this->_clients[ $uid ] === $client ) {
          $client->dispose();
          unset( $this->_clients[ $uid ] );

          $e =& new Event( 'clientRemoved', $this, $uid );
          $this->dispatch( $e );
        }
    }

    /**
     * @brief   Tente d'intercepter un client
     * @return  boolean
     */
    protected function _tryCatchClient() {
      $clientSocket = @socket_accept( $this->_socket );
      if ( $clientSocket !== false ) {
        $e =& new Event( 'clientArrival', $this, $clientSocket );
        $this->dispatch( $e );
        return true;
      }
      return false;
    }

    /**
     * @brief   Donne la main à chaque client pour qu'ils fassent ce qu'ils ont a faire
     * @return  void
     */
    protected function _listenToClients() {
      foreach( $this->_clients AS $uid => $client )
        if ( $this->_clients[ $uid ]->listen() ) // le client a agit
          $this->keepAlive(); // on garde le serveur en vie
    }

    abstract protected function _listen();
  }
?>