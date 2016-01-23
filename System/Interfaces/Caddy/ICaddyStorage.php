<?php
  /**
   * @package     	Caddy
   * @interface     ICaddyStorage
   * @author      	Jimmy CHARLEBOIS
   * @date        	07-03-2007
   * @brief       	Interface pour classe de stockage d'un caddy
   */
  interface ICaddyStorage {
    /**
     * @brief   Charge un caddy d'après son identifiant
     * @param   $caddyId    integer   identifiant du caddy
     * @return  ICaddy
     */
    public function &loadById( $caddyId );

    /**
     * @brief   Sauvegarde le caddy
     * @param   $caddyId    integer   identifiant du caddy
     * @return  boolean
     * @throw   Exception
     */
    public function save( &$caddyId = null );

    /**
     * @brief   Supprime un caddy d'après son identifiant
     * @param   $caddyId    integer   identifiant du caddy
     * @return  boolean
     */
    public function delete( $caddyId );
  }
?>