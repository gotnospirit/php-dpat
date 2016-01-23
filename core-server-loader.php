<?php
  /**
   * @author      	Jimmy CHARLEBOIS
   * @date        	23-04-2007
   * @brief       	Exemple de d'utilisation du serveur basique (System.Network.ClientServer.BasicServer)
   */
  require 'c.system.php';

  System::import( 'System.Network.ClientServer.BasicServer' );
  System::import( 'System.Network.ClientServer.BasicClient' );
  System::import( 'System.Network.ClientServer.AbstractServerListener' );
  System::import( 'System.Network.ClientServer.AbstractClientListener' );

  define( 'SERVER_PORT', 8000, true );
  define( 'SERVER_TIMEOUT', 15, true );
  define( 'CLIENT_TIMEOUT', 10, true );
  define( 'MAX_CONNECTIONS', 5, true );

  class BasicClientListener extends AbstractClientListener {
    public function __construct( &$dispatcher ) {
      parent::__construct( $dispatcher );
    }

    public function onTimeout( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );
      $e->getSource()->dispose();
    }
    public function onRead( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );
    }
    public function onWrite( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );
    }
    public function onDisconnected( IEvent &$e, $args = null ) {
      $this->_defaultBehaviour( $e );
      $e->getSource()->getServer()->removeClient( $e->getSource() );
    }
  }

  class BasicServerListener extends AbstractServerListener {
    public function __construct( &$dispatcher ) {
      parent::__construct( $dispatcher );
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
      $client =& new BasicClient( $e->getSource(), $e->getContext(), CLIENT_TIMEOUT );
      $client->addEventListener( new BasicClientListener( $client ) );
      $this->getTarget()->bindClient( $client );
    }
  }

  $server =& new BasicServer( SERVER_PORT, SERVER_TIMEOUT, MAX_CONNECTIONS );
  $server->addEventListener( new BasicServerListener( $server ) );
  $server->start();
?>