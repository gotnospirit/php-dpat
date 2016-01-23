<?php
  /**
   * @package     	Network.ClientServer
   * @class       	BasicServer
   * @author      	Jimmy CHARLEBOIS
   * @date        	23-04-2007
   * @brief       	Impl�mentation d'un serveur sans protocole
   */
  System::import( 'System.Network.ClientServer.AbstractServer' );

  class BasicServer extends AbstractServer {
    public function __construct( $port, $timeout, $max_connection ) {
      parent::__construct( $port, $timeout, $max_connection );
    }

    /**
     * @brief   Tente d'intercepter un nouveau client puis laisse la main � chaque client intercept�
     * @return  void
     */
    protected function _listen() {
      while( 1 ) {  // boucle infinie mais on g�re un timeout pour sortir proprement
        if ( $this->isTimeout() ) {
          $this->stop();
          break;
        }
        $this->_tryCatchClient();
        $this->_listenToClients();
      }
    }
  }
?>