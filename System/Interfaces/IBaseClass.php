<?php
  /**
   * @package     	Base
   * @interface     IBaseClass
   * @author      	Jimmy CHARLEBOIS
   * @date        	05-12-2006
   * @brief       	Interface pour la classe racine
   */

  interface IBaseClass {
    /**
     * @brief   Retourne le nom de la classe
     * @return  string
     */
    public function getClassname();

    /**
     * @brief   Indique si un objet est une instance de la classe
     * @param   $obj    mixed   l'objet � tester
     * @return  boolean
     */
    public function isInstanceOf( $obj );

    /**
     * @brief   Indique si un objet est �gale � un celui fourni en param�tre
     * @param   $o    IBaseClass
     * @return  bool
     * @todo    A introduire mais il faudra reprendre tous les fichiers d�pendants du syst�me (TPH, exemples, ...)
     */
//    public function equals( IBaseClass $o );
  }
?>