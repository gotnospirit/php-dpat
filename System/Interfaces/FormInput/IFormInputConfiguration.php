<?php
  /**
   * @package     	FormInput
   * @interface     IFormInputConfiguration
   * @author      	Jimmy CHARLEBOIS
   * @date        	25-01-2007
   * @brief       	Interface de marquage pour les configuration d'�l�ment de formulaire
   */
  System::import( 'System.Interfaces.IStorable' );

  interface IFormInputConfiguration extends IStorable {
    /**
     * @brief   Retourne le type d'�l�ment de configuration
     * @return  string
     */
    public function getType();
  }
?>