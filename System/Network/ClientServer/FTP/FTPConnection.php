<?php
  /**
   * @package     	Network.ClientServer.FTP
   * @class       	FTPConnection
   * @author      	Jimmy CHARLEBOIS
   * @date        	25-04-2007
   * @brief       	
   */
  System::import( 'System.Interfaces.Network.ClientServer.IClient' );
  System::import( 'System.Interfaces.Network.ClientServer.IClientListener' );
  System::import( 'System.Event.EventDispatcher' );
  System::import( 'System.Network.ClientServer.FTP.FTPMessage' );

  class FTPConnection extends EventDispatcher implements IClient, IClientListener {
    private $_clientControl;

    public function __construct( IClient &$client ) {
      parent::__construct();
      $this->_clientControl =& $client;
      $client->addEventListener( $this );
    }

    public function dispose() {
      $this->_clientControl->dispose();
    }

    public function getUID() {
      return $this->_clientControl->getUID();
    }
    public function setUID( $uid ) {
      $this->_clientControl->setUID( $uid );
    }
    public function &getServer() {
      return $this->_clientControl->getServer();
    }
    public function listen() {
      return $this->_clientControl->listen();
    }

    public function getAddress() {
      return $this->_clientControl->getAddress();
    }
    public function getPort() {
      return $this->_clientControl->getPort();
    }
    public function keepAlive() {
      $this->_clientControl->keepAlive();
    }
    public function isTimeout() {
      return $this->_clientControl->isTimeout();
    }

    public function controlRead() {
      return $this->_clientControl->read();
    }
    public function controlWrite( $data ) {
      return $this->_clientControl->write( $data );
    }

    public function onRead( IEvent &$e, $args = null ) {
      $e =& new Event( 'controlRead', $this, FTPMessage::parse( $e->getContext() ) );
      $this->dispatch( $e );
    }
    public function onWrite( IEvent &$e, $args = null ) {
      $e =& new Event( 'controlWrite', $this, $e->getContext() );
      $this->dispatch( $e );
    }
    public function onDisconnected( IEvent &$e, $args = null ) {
      $e->getSource()->getServer()->removeClient( $this );

      $e =& new Event( 'controlClose', $this, $e->getContext() );
      $this->dispatch( $e );
    }
    public function onTimeout( IEvent &$e, $args = null ) {
      $e->getSource()->getServer()->removeClient( $this );

      $e =& new Event( 'controlTimeout', $this, $e->getContext() );
      $this->dispatch( $e );
    }
  }
?>