<?php
  /**
   * @package     	Base
   * @interface    	IResource
   * @author      	Jimmy CHARLEBOIS
   * @date        	24-01-2006
   * @brief       	Interface pour les objets devant gérer une/des ressource(s)
   */

  interface IResource {
    /**
     * @brief   Permet de supprimer les éventuelles resources associées
     * @return  void
     */
    public function dispose();
  }
?>