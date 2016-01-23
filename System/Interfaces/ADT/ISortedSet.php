<?php
  /**
   * @package     	ADT
   * @interface     ISortedSet
   * @author      	Jimmy CHARLEBOIS
   * @date        	22-02-2007
   * @brief       	Interface pour collection de valeurs tri�es
   */
  System::import( 'System.Interfaces.ADT.ISet' );

  interface ISortedSet extends ISet {
    /**
     * @brief   Retourne le comparateur associ� ou null si la collection utilises l'ordre naturel des donn�es
     * @return  IComparator|null
     */
    public function getComparator();

    /**
     * @brief   Retourne le premier �l�ment (le plus petit) de la collection
     * @return  mixed
     */
    public function first();

    /**
     * @brief   Retourne une collection de valeurs des premiers �l�ments ( < $to_element )
     * @param   $to_element     integer
     * @return  ISortedSet
     * @throw   OutOfBoundsException
     */
    public function &headSet( $to_element );

    /**
     * @brief   Retourne le dernier �l�ment (le plus grand) de la collection
     * @return  mixed
     */
    public function last();

    /**
     * @brief   Retourne une collection de valeurs
     * @param   $from_element   integer
     * @param   $to_element     integer
     * @return  ISortedSet
     * @note    Si $from_element = $to_element la collection retourn�e sera vide
     * @throw   OutOfBoundsException
     */
    public function &subSet( $from_element, $to_element );

    /**
     * @brief   Retourne une collection de valeurs des derniers �l�ments ( >= $from_element )
     * @param   $from_element   integer
     * @return  ISortedSet
     * @throw   OutOfBoundsException
     */
    public function &tailSet( $from_element );
  }
?>