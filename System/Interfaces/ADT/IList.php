<?php
  /**
   * @package     	ADT
   * @interface     IList
   * @author      	Jimmy CHARLEBOIS
   * @date        	19-02-2007
   * @brief       	Interface pour les collections de valeurs
   */
  System::import( 'System.Interfaces.ADT.ICollection' );

  interface IList extends ICollection {
    /**
     * @brief   Retourne l'élément situé à la position spécifiée
     * @param   $index    integer
     * @return  mixed|null
     */
    public function &get( $index );

    /**
     * @brief   Définit un élément à une position particulière de la collection
     * @param   $index    integer
     * @param   $o        mixed     
     * @return  mixed
     * @throw   OutOfBoundsException, UnsupportedOperationException, IllegalArgumentException
     */
    public function set( $index, $o );

    /**
     * @brief   Retourne la position d'un élément spécifié
     * @param   $o    mixed   l'élément dont l'on souhaite connaitre la position dans la collection
     * @return  integer|null
     */
    public function indexOf( $o );

    /**
     * @brief   Retourne la dernière position d'un élément spécifié
     * @param   $o    mixed   l'élément dont l'on souhaite connaitre la position dans la collection
     * @return  integer|null
     */
    public function lastIndexOf( $o );
  }
?>