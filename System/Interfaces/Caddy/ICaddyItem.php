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
     * @brief   Retourne la cl� de l'�l�ment
     * @return  string
     */
    public function getKey();

    /**
     * @brief   Retourne la quantit� de l'�l�ment
     * @return  integer
     */
    public function getQuantity();
    /**
     * @brief   D�finit la quantit� de l'�l�ment
     * @param   $value    integer   la nouvelle quantit�
     * @return  void
     * @throw   TypeMismatchException
     */
    public function setQuantity( $value );

    /**
     * @brief   Retourne le prix unitaire de l'�l�ment
     * @return  float
     */
    public function getPrice();
    /**
     * @brief   D�finit le prix unitaire de l'�l�ment
     * @param   $value    float   le nouveau prix unitaire
     * @throw   TypeMismatchException
     */
    public function setPrice( $value );

    /**
     * @brief   Ajoute une caract�ristique � l'�l�ment
     * @param   $feat   ICaddyItemFeature   la caract�ristique � ajouter � l'�l�ment
     * @return  void
     */
    public function addCaddyItemFeature( ICaddyItemFeature &$feat );
    /**
     * @brief   Supprime une caract�ristique de l'�l�ment
     * @param   $feat   ICaddyItemFeature   la caract�ristique � supprimer de l'�l�ment
     * @return  boolean
     */
    public function removeCaddyItemFeature( ICaddyItemFeature &$feat );

    /**
     * @brief   Indique si l'�l�ment du caddy est consid�r� comme �gal � celui fournit en param�tre
     * @param   $item   ICaddyItem    l'�l�ment a compar�
     * @return  boolean
     */
    public function equals( ICaddyItem &$item );
  }
?>