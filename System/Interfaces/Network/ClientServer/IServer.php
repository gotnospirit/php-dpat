<?php
  /**
   * @package     	Network.ClientServer
   * @interface     IServer
   * @author      	Jimmy CHARLEBOIS
   * @date        	23-04-2007
   * @brief       	Interface pour l'impl�mentation d'un serveur
   */
  System::import( 'System.Interfaces.Network.ClientServer.IHost' );

  interface IServer extends IHost {
    /**
     * @brief   D�marre le serveur
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