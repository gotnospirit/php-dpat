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
     * @brief   Ajoute un élément au caddy
     * @param   $item   ICaddyItem    l'élément à ajouter
     * @return  void
     */
    public function addCaddyItem( ICaddyItem &$item );

    /**
     * @brief   Supprime un élément du caddy
     * @param   $item   ICaddyItem    l'élément à retirer
     * @return  boolean
     */
    public function removeCaddyItem( ICaddyItem &$item );

    /**
     * @brief   Retourne un élément du caddy d'après son identifiant
     * @param   $itemKey    string    identifiant de l'élément
     * @return  ICaddyItem|null
     */
    public function &getCaddyItem( $itemKey );

    /**
     * @brief   Supprime tous les éléments du caddy
     * @return  void
     */
    public function clear();
  }
?>