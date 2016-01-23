<?php
  /**
   * @package     	ADT
   * @interface     ISortedSet
   * @author      	Jimmy CHARLEBOIS
   * @date        	22-02-2007
   * @brief       	Interface pour collection de valeurs triées
   */
  System::import( 'System.Interfaces.ADT.ISet' );

  interface ISortedSet extends ISet {
    /**
     * @brief   Retourne le comparateur associé ou null si la collection utilises l'ordre naturel des données
     * @return  IComparator|null
     */
    public function getComparator();

    /**
     * @brief   Retourne le premier élément (le plus petit) de la collection
     * @return  mixed
     */
    public function first();

    /**
     * @brief   Retourne une collection de valeurs des premiers éléments ( < $to_element )
     * @param   $to_element     integer
     * @return  ISortedSet
     * @throw   OutOfBoundsException
     */
    public function &headSet( $to_element );

    /**
     * @brief   Retourne le dernier élément (le plus grand) de la collection
     * @return  mixed
     */
    public function last();

    /**
     * @brief   Retourne une collection de valeurs
     * @param   $from_element   integer
     * @param   $to_element     integer
     * @return  ISortedSet
     * @note    Si $from_element = $to_element la collection retournée sera vide
     * @throw   OutOfBoundsException
     */
    public function &subSet( $from_element, $to_element );

    /**
     * @brief   Retourne une collection de valeurs des derniers éléments ( >= $from_element )
     * @param   $from_element   integer
     * @return  ISortedSet
     * @throw   OutOfBoundsException
     */
    public function &tailSet( $from_element );
  }
?>