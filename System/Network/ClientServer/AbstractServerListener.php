<?php
  /**
   * @package     	Network.ClientServer
   * @class       	AbstractServerListener
   * @author      	Jimmy CHARLEBOIS
   * @date        	24-04-2007
   * @brief       	Classe abstraite permettant l'écoute des évènements d'un AbstractServer
   */
  System::import( 'System.Interfaces.Network.ClientServer.IServerListener' );
  System::import( 'System.Event.EventListener' );
  System::import( 'System.IO.Log.FileLog' );

  abstract class AbstractServerListener extends EventListener implements IServerListener {
    private $_log;

    public function __construct( AbstractServer &$dispatcher ) {
      parent::__construct( $dispatcher );
      $this->_log =& new FileLog( 'logs/basicserver.log' );
      $this->_log->reset();
    }

    public function __destruct() {
      $this->_log->dispose();
    }

    protected function _defaultBehaviour( IEvent $e ) {
      $msg = '['.get_class( $e->getSource() ).'->'.$e->getName().'] '.trim( (string)$e->getContext() );
      $this->_log->write( $msg );
      echo $msg.System::crlf;
    }
  }
?>