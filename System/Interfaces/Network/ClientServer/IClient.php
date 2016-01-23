<?php
  /**
   * @package     	Network.ClientServer
   * @interface     IClient
   * @author      	Jimmy CHARLEBOIS
   * @date        	24-04-2007
   * @brief       	
   */
  System::import( 'System.Interfaces.Network.ClientServer.IHost' );

  interface IClient extends IHost {
    /**
     * @brief   Retourne l'identifiant, assign� par le serveur, du client
     * @return  mixed
     */
    public function getUID();

    /**
     * @brief   D�finit l'identifiant unique du client
     * @param   $uid    mixed   identifiant attribu� par le serveur
     * @return  void
     */
    public function setUID( $uid );

    /**
     * @brief   Retourne le serveur qui a intercept� le client
     * @return  AbstractServer
     */
    public function &getServer();

    /**
     * @brief   M�thode appel�e par le serveur qui permet au client d'agir
     * @return  boolean
     */
    public function listen();
  }
?>