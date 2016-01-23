<?php
  /**
   * @package       Caddy
   * @interface     ICaddyItemFeature
   * @author        Jimmy CHARLEBOIS
   * @date          06-03-2007
   * @brief         
   */
  System::import( 'System.Interfaces.IStorable' );

  interface ICaddyItemFeature extends IStorable {
    /**
     * @brief   Retourne la clé de la propriété
     * @return  string
     */
    public function getKey();
    /**
     * @brief   Retourne la valeur de la propriété
     * @return  mixed
     */
    public function getValue();
    /**
     * @brief   Définit la valeur de la propriété
     * @param   $value    mixed   la nouvelle valeur
     * @return  void
     */
    public function setValue( $value );
  }
?>