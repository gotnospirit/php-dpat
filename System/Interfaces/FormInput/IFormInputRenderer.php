<?php
  /**
   * @package     	FormInput
   * @interface     IFormInputRenderer
   * @author      	Jimmy CHARLEBOIS
   * @date        	09-03-2007
   * @brief       	
   */
  interface IFormInputRenderer {
    /**
     * @brief   Dessine l'élément pour visualisation
     * @return  mixed
     */
    public function renderRead();

    /**
     * @brief   Dessine l'élément pour édition
     * @return  mixed
     */
    public function renderEdit();

    /**
     * @brief   Dessine l'élément pour recherche
     * @return  mixed
     */
    public function renderSearch();
  }
?>