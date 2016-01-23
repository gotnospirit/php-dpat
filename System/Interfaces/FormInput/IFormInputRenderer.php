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
     * @brief   Dessine l'�l�ment pour visualisation
     * @return  mixed
     */
    public function renderRead();

    /**
     * @brief   Dessine l'�l�ment pour �dition
     * @return  mixed
     */
    public function renderEdit();

    /**
     * @brief   Dessine l'�l�ment pour recherche
     * @return  mixed
     */
    public function renderSearch();
  }
?>