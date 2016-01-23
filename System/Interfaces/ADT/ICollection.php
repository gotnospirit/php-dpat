<?php
  /**
   * @package     	ADT
   * @interface     ICollection
   * @author      	Jimmy CHARLEBOIS
   * @date        	21-02-2007
   * @brief       	Interface pour les collections
   * @todo          étendre de IStorable
   */
  System::import( 'System.Interfaces.Iteration.IIterable' );

  interface ICollection extends IIterable {
    /**
     * @brief   Ajoute un élément à la collection
     * @param   $o    mixed   élément à ajouter
     * @return  boolean
     * @throw   IllegalArgumentException
     */
    public function add( $o );

    /**
     * @brief   Copie les éléments d'une collection
     * @param   $collection   ICollection   Collection dont les éléments doivent être copiés
     * @return  boolean
     */
    public function addAll( ICollection $collection );

    /**
     * @brief   Supprime tous les éléments contenus par la collection
     * @return  void
     */
    public function clear();

    /**
     * @brief   Indique si la collection contient l'élément spécifié
     * @param   $o    mixed   élément pour lequel on souhaite savoir s'il est dans la collection
     * @return  boolean
     */
    public function contains( $o );

    /**
     * @brief   Indique si la collection contient tous les éléments de celle passée en paramètre
     * @param   $collection   ICollection
     * @return  boolean
     */
    public function containsAll( ICollection $collection );

    /**
     * @brief   Indique si la collection est vide
     * @return  boolean
     */
    public function isEmpty();

    /**
     * @brief   Supprime un élément de la collection
     * @param   $o    mixed   l'élément à supprimer
     * @return  boolean
     * @throw   UnsupportedOperationException
     */
    public function remove( $o );

    /**
     * @brief   Supprime de la collection tous les éléments de celle passée en paramètre
     * @param   $collection   ICollection
     * @return  boolean
     * @throw   UnsupportedOperationException
     */
    public function removeAll( ICollection $collection );

    /**
     * @brief   Retourne le nombre d'éléments contenus par la collection
     * @return  integer
     */
//    public function size();   //  héritée de IIterable

    /**
     * @see     __toString
     */
    public function toString();

    /**
     * @brief   Retourne un tableau des éléments de la collection
     * @return  array
     */
//    public function toArray();   //  héritée de IIterable

    /**
     * @brief   Retourne une version linaire de la collection
     * @return  string
     */
    public function __toString();
  }
?>