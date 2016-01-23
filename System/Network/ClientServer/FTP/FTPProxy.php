<?php
  /**
   * @package     	Network.ClientServer.FTP
   * @class       	FTPProxy
   * @author      	Jimmy CHARLEBOIS
   * @date        	24-04-2007
   * @brief       	
   */
  System::import( 'System.Interfaces.Network.ClientServer.IServer' );
  System::import( 'System.Interfaces.Network.ClientServer.IServerListener' );
  System::import( 'System.Interfaces.Network.ClientServer.IClientListener' );
  System::import( 'System.Event.EventListener' );
  System::import( 'System.IO.Log.FileLog' );
  System::import( 'System.Network.ClientServer.BasicServer' );
  System::import( 'System.Network.ClientServer.BasicClient' );
  System::import( 'System.Network.ClientServer.FTP.FTPConnection' );

  if ( !defined( 'CLIENT_TIMEOUT' ) )
    define( 'CLIENT_TIMEOUT', 5, true );

  class FTPProxy extends EventListener implements IServer, IServerListener, IClientListener {
    private $_log;
    private $_server_daemon;

    public function __construct( $port, $timeout, $max_connection ) {
      $this->_log =& new FileLog( 'logs/ftpproxy.log' );
      $this->_log->reset();
      $this->_server_daemon =& new BasicServer( $port, $timeout, $max_connection );

      parent::__construct( $this->_server_daemon );
      $this->_server_daemon->addEventListener( $this );
    }

    public function __destruct() {
      $this->_log->dispose();
    }

    public function dispose() {
      $this->_server_daemon->dispose();
    }

    public function start() {
      return $this->_server_daemon->start();
    }
    public function stop() {
      return $this->_server_daemon->stop();
    }
    public function getAddress() {
      return $this->_server_daemon->getAddress();
    }
    public function getPort() {
      return $this->_server_daemon->getPort();
    }
    public function keepAlive() {
      return $this->_server_daemon->keepAlive();
    }
    public function isTimeout() {
      return $this->_server_daemon->isTimeout();
    }

    protected function _defaultBehaviour( IEvent $e ) {
      $msg = '['. get_class( $e->getSource() ).'->'.$e->getName().'] '.trim( (string)$e->getContext() );
      $this->_log->write( $msg );
      echo $msg.System::crlf;
    }

    public function onControlRead( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );

      $clientMessage = $e->getContext();
      if ( !is_null( $clientMessage ) ) {
        if ( !is_null( $clientMessage->code ) ) {
          echo 'Code à traiter'.System::crlf
            . (string)$clientMessage.System::crlf;
        } elseif ( !is_null( $clientMessage->command ) ) {
          /**
           * @todo  Refaire cette partie en introduisant un objet qui va gérer tout le dialogue et les sequencages entre le client et le serveur
           */
          if ( 'USER' == $clientMessage->command ) {
            if ( 'jimmy' == $clientMessage->params ) {
              $e->getSource()->controlWrite( '331 Password required for '.$clientMessage->params.System::crlf );
            }
          } elseif ( 'PASS' == $clientMessage->command ) {
            $e->getSource()->controlWrite( '530 User %s cannot log in.'.System::crlf );
          }
        }
      }
    }
    public function onControlWrite( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );
    }
    public function onControlClose( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );
    }
    public function onControlTimeout( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );
    }


    public function onTimeout( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );
    }
    public function onError( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );
    }
    public function onBeforeClose( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );
    }
    public function onStart( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );
    }
    public function onClose( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );
    }
    public function onClientRemoved( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );
    }
    public function onClientArrival( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );

      $client =& new FTPConnection( new BasicClient( $this->_server_daemon, $e->getContext(), CLIENT_TIMEOUT ) );
      $client->addEventListener( $this );
      $this->_server_daemon->bindClient( $client );

      $this->_log->write( 'New connection from '.$client->getAddress().':'.$client->getPort() );

      //  On présente le serveur au client connecté
      $client->controlWrite( '200 FTPProxy 0.1'.System::crlf );
    }
  }
?>