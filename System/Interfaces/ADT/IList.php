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
     * @brief   Retourne l'�l�ment situ� � la position sp�cifi�e
     * @param   $index    integer
     * @return  mixed|null
     */
    public function &get( $index );

    /**
     * @brief   D�finit un �l�ment � une position particuli�re de la collection
     * @param   $index    integer
     * @param   $o        mixed     
     * @return  mixed
     * @throw   OutOfBoundsException, UnsupportedOperationException, IllegalArgumentException
     */
    public function set( $index, $o );

    /**
     * @brief   Retourne la position d'un �l�ment sp�cifi�
     * @param   $o    mixed   l'�l�ment dont l'on souhaite connaitre la position dans la collection
     * @return  integer|null
     */
    public function indexOf( $o );

    /**
     * @brief   Retourne la derni�re position d'un �l�ment sp�cifi�
     * @param   $o    mixed   l'�l�ment dont l'on souhaite connaitre la position dans la collection
     * @return  integer|null
     */
    public function lastIndexOf( $o );
  }
?>