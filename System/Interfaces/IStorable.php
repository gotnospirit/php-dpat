<?php
  /**
   * @package     	Base
   * @interface     IStorable
   * @author      	Jimmy CHARLEBOIS
   * @date        	09-02-2007
   * @brief         Interface pour les objets pouvant �tre stock�s
   */
  System::import( 'System.Interfaces.IBaseClass' );

  interface IStorable extends IBaseClass {
    /**
     * @brief   Retourne une version serializable de l'objet
     * @return  array|scalar
     */
    public function store();

    /**
     * @brief   Red�finit les propri�t�s de l'objet d'apr�s les donn�es fournit
     * @param   $props    array   collection des propri�t�s � restaurer
     * @return  void
     * @throw   Exception
     */
    public static function restore( $props );
  }
?>