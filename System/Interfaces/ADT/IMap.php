<?php
  /**
   * @package     	ADT
   * @interface     IMap
   * @author      	Jimmy CHARLEBOIS
   * @date        	21-02-2007
   * @brief       	Interface pour les collections associants cl�s et valeurs
   * @todo          �tendre de IStorable
   */
  System::import( 'System.Interfaces.Iteration.IIterable' );

  interface IMap extends IIterable {
    /**
     * @brief   Supprime tous les �l�ments contenus par la collection
     * @return  void
     */
    public function clear();

    /**
     * @brief   Indique si la Map contient la cl� sp�cifi�e
     * @return  boolean
     */
    public function containsKey( $key );

    /**
     * @brief   Indique si la Map contient la valeur sp�cifi�e
     * @return  boolean
     */
    public function containsValue( $value );

    /**
     * @brief   Retourne une collection d'objet Entry
     * @return  AbstractSet
     */
    public function entrySet();

    /**
     * @brief   Retourne une collection des cl�s
     * @return  AbstractSet
     */
    public function keySet();

    /**
     * @brief   Retourne l'�l�ment situ� � la position sp�cifi�e
     * @param   $key    mixed   une cl� de la Map
     * @return  mixed|null
     */
    public function &get( $key );

    /**
     * @brief   Indique si la collection est vide
     * @return  boolean
     */
    public function isEmpty();

    /**
     * @brief   Ajoute un �l�ment � la Map
     * @param   $key    mixed   la cl� pour stocker l'�l�ment dans la collection
     * @param   $value  mixed   l'�l�ment � stocker
     * @return  mixed|null
     * @note    Retourne l'�l�ment pr�c�demment associ� � la cl� sp�cifi�e ou null si l'�l�ment n'�tait pas encore mapp�
     * @throw   UnsupportedOperationException
     */
    public function put( $key, $value );

    /**
     * @brief   Copie tous les �l�ments de l'objet IMap fourni en param�tre
     * @param   $map    IMap    Map dont les �l�ments doivent �tre copi�s
     * @return  void
     * @throw   UnsupportedOperationException
     */
    public function putAll( IMap $map );

    /**
     * @brief   Supprime un �l�ment de la collection
     * @param   $key    mixed   une cl� de la Map
     * @return  boolean
     * @throw   UnsupportedOperationException
     */
    public function remove( $key );

    /**
     * @brief   Retourne le nombre d'�l�ments contenus par la collection
     * @return  integer
     */
//    public function size();   //  h�rit�e de IIterable

    /**
     * @brief   Retourne un tableau des �l�ments de la collection
     * @return  array
     */
//    public function toArray();   //  h�rit�e de IIterable

    /**
     * @brief   Retourne une collection des �l�ments mapp�s dans la collection
     * @return  array
     * @see     toArray
     */
    public function values();
  }
?>