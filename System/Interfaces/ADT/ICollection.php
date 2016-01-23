<?php
  /**
   * @package     	ADT
   * @interface     ICollection
   * @author      	Jimmy CHARLEBOIS
   * @date        	21-02-2007
   * @brief       	Interface pour les collections
   * @todo          �tendre de IStorable
   */
  System::import( 'System.Interfaces.Iteration.IIterable' );

  interface ICollection extends IIterable {
    /**
     * @brief   Ajoute un �l�ment � la collection
     * @param   $o    mixed   �l�ment � ajouter
     * @return  boolean
     * @throw   IllegalArgumentException
     */
    public function add( $o );

    /**
     * @brief   Copie les �l�ments d'une collection
     * @param   $collection   ICollection   Collection dont les �l�ments doivent �tre copi�s
     * @return  boolean
     */
    public function addAll( ICollection $collection );

    /**
     * @brief   Supprime tous les �l�ments contenus par la collection
     * @return  void
     */
    public function clear();

    /**
     * @brief   Indique si la collection contient l'�l�ment sp�cifi�
     * @param   $o    mixed   �l�ment pour lequel on souhaite savoir s'il est dans la collection
     * @return  boolean
     */
    public function contains( $o );

    /**
     * @brief   Indique si la collection contient tous les �l�ments de celle pass�e en param�tre
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
     * @brief   Supprime un �l�ment de la collection
     * @param   $o    mixed   l'�l�ment � supprimer
     * @return  boolean
     * @throw   UnsupportedOperationException
     */
    public function remove( $o );

    /**
     * @brief   Supprime de la collection tous les �l�ments de celle pass�e en param�tre
     * @param   $collection   ICollection
     * @return  boolean
     * @throw   UnsupportedOperationException
     */
    public function removeAll( ICollection $collection );

    /**
     * @brief   Retourne le nombre d'�l�ments contenus par la collection
     * @return  integer
     */
//    public function size();   //  h�rit�e de IIterable

    /**
     * @see     __toString
     */
    public function toString();

    /**
     * @brief   Retourne un tableau des �l�ments de la collection
     * @return  array
     */
//    public function toArray();   //  h�rit�e de IIterable

    /**
     * @brief   Retourne une version linaire de la collection
     * @return  string
     */
    public function __toString();
  }
?>