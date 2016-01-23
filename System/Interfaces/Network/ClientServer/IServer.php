<?php
  /**
   * @package     	Network.ClientServer
   * @interface     IServer
   * @author      	Jimmy CHARLEBOIS
   * @date        	23-04-2007
   * @brief       	Interface pour l'implémentation d'un serveur
   */
  System::import( 'System.Interfaces.Network.ClientServer.IHost' );

  interface IServer extends IHost {
    /**
     * @brief   Démarre le serveur
     * @return  void
     */
    public function start();

    /**
     * @brief   Stoppe le serveur
     * @return  void
     */
    public function stop();
  }
?>