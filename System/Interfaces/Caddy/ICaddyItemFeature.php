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
     * @brief   Retourne la cl� de la propri�t�
     * @return  string
     */
    public function getKey();
    /**
     * @brief   Retourne la valeur de la propri�t�
     * @return  mixed
     */
    public function getValue();
    /**
     * @brief   D�finit la valeur de la propri�t�
     * @param   $value    mixed   la nouvelle valeur
     * @return  void
     */
    public function setValue( $value );
  }
?>