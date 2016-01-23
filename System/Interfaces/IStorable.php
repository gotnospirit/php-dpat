<?php
  /**
   * @package     	Base
   * @interface     IStorable
   * @author      	Jimmy CHARLEBOIS
   * @date        	09-02-2007
   * @brief         Interface pour les objets pouvant être stockés
   */
  System::import( 'System.Interfaces.IBaseClass' );

  interface IStorable extends IBaseClass {
    /**
     * @brief   Retourne une version serializable de l'objet
     * @return  array|scalar
     */
    public function store();

    /**
     * @brief   Redéfinit les propriétés de l'objet d'après les données fournit
     * @param   $props    array   collection des propriétés à restaurer
     * @return  void
     * @throw   Exception
     */
    public static function restore( $props );
  }
?>