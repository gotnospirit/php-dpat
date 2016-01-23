<?php
  /**
   * @package     	Caddy
   * @interface     ICaddy
   * @author      	Jimmy CHARLEBOIS
   * @date        	06-03-2007
   * @brief       	
   */
  System::import( 'System.Interfaces.IStorable' );

  interface ICaddy extends IStorable {
    /**
     * @brief   Ajoute un �l�ment au caddy
     * @param   $item   ICaddyItem    l'�l�ment � ajouter
     * @return  void
     */
    public function addCaddyItem( ICaddyItem &$item );

    /**
     * @brief   Supprime un �l�ment du caddy
     * @param   $item   ICaddyItem    l'�l�ment � retirer
     * @return  boolean
     */
    public function removeCaddyItem( ICaddyItem &$item );

    /**
     * @brief   Retourne un �l�ment du caddy d'apr�s son identifiant
     * @param   $itemKey    string    identifiant de l'�l�ment
     * @return  ICaddyItem|null
     */
    public function &getCaddyItem( $itemKey );

    /**
     * @brief   Supprime tous les �l�ments du caddy
     * @return  void
     */
    public function clear();
  }
?>