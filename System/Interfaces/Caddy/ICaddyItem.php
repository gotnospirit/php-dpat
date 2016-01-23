<?php
  /**
   * @package     	Caddy
   * @interface     ICaddyItem
   * @author      	Jimmy CHARLEBOIS
   * @date        	06-03-2007
   * @brief       	
   */
  System::import( 'System.Interfaces.IStorable' );

  interface ICaddyItem extends IStorable {
    /**
     * @brief   Retourne la clé de l'élément
     * @return  string
     */
    public function getKey();

    /**
     * @brief   Retourne la quantité de l'élément
     * @return  integer
     */
    public function getQuantity();
    /**
     * @brief   Définit la quantité de l'élément
     * @param   $value    integer   la nouvelle quantité
     * @return  void
     * @throw   TypeMismatchException
     */
    public function setQuantity( $value );

    /**
     * @brief   Retourne le prix unitaire de l'élément
     * @return  float
     */
    public function getPrice();
    /**
     * @brief   Définit le prix unitaire de l'élément
     * @param   $value    float   le nouveau prix unitaire
     * @throw   TypeMismatchException
     */
    public function setPrice( $value );

    /**
     * @brief   Ajoute une caractéristique à l'élément
     * @param   $feat   ICaddyItemFeature   la caractéristique à ajouter à l'élément
     * @return  void
     */
    public function addCaddyItemFeature( ICaddyItemFeature &$feat );
    /**
     * @brief   Supprime une caractéristique de l'élément
     * @param   $feat   ICaddyItemFeature   la caractéristique à supprimer de l'élément
     * @return  boolean
     */
    public function removeCaddyItemFeature( ICaddyItemFeature &$feat );

    /**
     * @brief   Indique si l'élément du caddy est considéré comme égal à celui fournit en paramètre
     * @param   $item   ICaddyItem    l'élément a comparé
     * @return  boolean
     */
    public function equals( ICaddyItem &$item );
  }
?>