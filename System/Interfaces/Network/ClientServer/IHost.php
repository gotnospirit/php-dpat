<?php
  /**
   * @package       Network.ClientServer
   * @interface     IHost
   * @author        Jimmy CHARLEBOIS
   * @date          23-04-2007
   * @brief         Interface pour l'implémentation d'un hôte pour connexion client-serveur
   */
  System::import( 'System.Interfaces.IResource' );

  interface IHost extends IResource {
    /**
     * @brief   Retourne l'adresse IP de l'hôte
     * @return  string
     */
    public function getAddress();

    /**
     * @brief   Retourne le port de communication de l'hôte
     * @return  integer
     */
    public function getPort();

    /**
     * @brief   Evite que l'hôte ne fasse un timeout
     * @return  void
     */
    public function keepAlive();

    /**
     * @brief   Indique si l'hôte a fermé sa connexion
     * @return  boolean
     */
    public function isTimeout();
  }
?>