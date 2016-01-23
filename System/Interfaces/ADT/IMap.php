<?php
  /**
   * @package     	ADT
   * @interface     IMap
   * @author      	Jimmy CHARLEBOIS
   * @date        	21-02-2007
   * @brief       	Interface pour les collections associants clés et valeurs
   * @todo          étendre de IStorable
   */
  System::import( 'System.Interfaces.Iteration.IIterable' );

  interface IMap extends IIterable {
    /**
     * @brief   Supprime tous les éléments contenus par la collection
     * @return  void
     */
    public function clear();

    /**
     * @brief   Indique si la Map contient la clé spécifiée
     * @return  boolean
     */
    public function containsKey( $key );

    /**
     * @brief   Indique si la Map contient la valeur spécifiée
     * @return  boolean
     */
    public function containsValue( $value );

    /**
     * @brief   Retourne une collection d'objet Entry
     * @return  AbstractSet
     */
    public function entrySet();

    /**
     * @brief   Retourne une collection des clés
     * @return  AbstractSet
     */
    public function keySet();

    /**
     * @brief   Retourne l'élément situé à la position spécifiée
     * @param   $key    mixed   une clé de la Map
     * @return  mixed|null
     */
    public function &get( $key );

    /**
     * @brief   Indique si la collection est vide
     * @return  boolean
     */
    public function isEmpty();

    /**
     * @brief   Ajoute un élément à la Map
     * @param   $key    mixed   la clé pour stocker l'élément dans la collection
     * @param   $value  mixed   l'élément à stocker
     * @return  mixed|null
     * @note    Retourne l'élément précédemment associé à la clé spécifiée ou null si l'élément n'était pas encore mappé
     * @throw   UnsupportedOperationException
     */
    public function put( $key, $value );

    /**
     * @brief   Copie tous les éléments de l'objet IMap fourni en paramètre
     * @param   $map    IMap    Map dont les éléments doivent être copiés
     * @return  void
     * @throw   UnsupportedOperationException
     */
    public function putAll( IMap $map );

    /**
     * @brief   Supprime un élément de la collection
     * @param   $key    mixed   une clé de la Map
     * @return  boolean
     * @throw   UnsupportedOperationException
     */
    public function remove( $key );

    /**
     * @brief   Retourne le nombre d'éléments contenus par la collection
     * @return  integer
     */
//    public function size();   //  héritée de IIterable

    /**
     * @brief   Retourne un tableau des éléments de la collection
     * @return  array
     */
//    public function toArray();   //  héritée de IIterable

    /**
     * @brief   Retourne une collection des éléments mappés dans la collection
     * @return  array
     * @see     toArray
     */
    public function values();
  }
?>