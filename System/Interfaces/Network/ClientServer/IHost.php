<?php
  /**
   * @package       Network.ClientServer
   * @interface     IHost
   * @author        Jimmy CHARLEBOIS
   * @date          23-04-2007
   * @brief         Interface pour l'impl�mentation d'un h�te pour connexion client-serveur
   */
  System::import( 'System.Interfaces.IResource' );

  interface IHost extends IResource {
    /**
     * @brief   Retourne l'adresse IP de l'h�te
     * @return  string
     */
    public function getAddress();

    /**
     * @brief   Retourne le port de communication de l'h�te
     * @return  integer
     */
    public function getPort();

    /**
     * @brief   Evite que l'h�te ne fasse un timeout
     * @return  void
     */
    public function keepAlive();

    /**
     * @brief   Indique si l'h�te a ferm� sa connexion
     * @return  boolean
     */
    public function isTimeout();
  }
?>