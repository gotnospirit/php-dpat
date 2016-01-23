<?php
  /**
   * @package       Network.ClientServer
   * @class         AbstractClient
   * @author        Jimmy CHARLEBOIS
   * @date          24-04-2007
   * @brief         Classe abstraite servant de socle à l'implémentation d'un client
   */
  System::import( 'System.Interfaces.Network.ClientServer.IClient' );
  System::import( 'System.Interfaces.IO.IStream' );
  System::import( 'System.Event.EventDispatcher' );
  System::import( 'System.Event.Event' );

  abstract class AbstractClient extends EventDispatcher implements IClient, IStream {
    private $_uid;
    private $_address;
    private $_port;
    private $_timeout;
    private $_last_time;

    private $_server;
    private $_socket;

    public function __construct( AbstractServer &$server, $socket, $timeout ) {
      parent::__construct();

      $this->_uid = null;
      $this->_timeout = $timeout;
      $this->_last_time = time();

      socket_getpeername( $socket, $this->_address, $this->_port );
      socket_set_nonblock( $socket );

      $this->_socket =& $socket;
      $this->_server =& $server;
    }

    public function __destruct() {
      $this->dispose();
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
        $e =& new Event( 'timeout', $this, 'Le client en a marre d\'attendre' );
        $this->dispatch( $e );
      }
      return $rv;
    }

    public function getUID() {
      return $this->_uid;
    }
    public function setUID( $uid ) {
      $this->_uid = $uid;
    }
    public function &getServer() {
      return $this->_server;
    }
    public function listen() {
      if ( $this->isTimeout() )
        return false;
      if ( $this->read() )
        $this->keepAlive();
      return true;
    }
    public function read() {
      $data = @socket_read( $this->_socket, 4096, PHP_BINARY_READ );
      if ( mb_strlen( $data ) > 0 ) {
        $e =& new Event( 'read', $this, $data );
        $this->dispatch( $e );
        return true;
      }
      return false;
    }
    public function write( $data ) {
      if ( !$this->isTimeout() ) {
        $writtenBytes = @socket_write( $this->_socket, $data, mb_strlen( $data ) );
        if ( $writtenBytes !== false ) {
          $e =& new Event( 'write', $this, $data );
          $this->dispatch( $e );
        }
        return $writtenBytes;
      }
    }

    public function dispose() {
      if ( is_null( $this->_socket ) || $this->_socket === false )
        return true;

      @socket_shutdown( $this->_socket, 2 );
      socket_close( $this->_socket );
      $this->_socket = null;

      $e =& new Event( 'disconnected', $this, 'Le client est arrêté.' );
      $this->dispatch( $e );
    }
  }
?>