<?php
  /**
   * @package       ADT
   * @interface     IStack
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Interface pour file d'attente du type LIFO
   */
  System::import( 'System.Interfaces.ADT.IList' );

  interface IStack extends IList {
    /**
     * @brief   Retourne l'élément en dernier dans la collection
     * @return  mixed
     */
    public function peek();

    /**
     * @brief   Retourne l'élément en dernier dans la collection et le supprime de celle-ci
     * @return  mixed
     */
    public function pop();

    /**
     * @brief   Ajoute un élément à la collection
     * @param   $element    mixed   l'élément à ajouter
     * @return  void
     */
    public function push( $element );

    /**
     * @brief   Retourne l'index d'un élément de la collection
     * @param   $element    mixed   l'élément à ajouter
     * @return  integer|null
     */
    public function search( $element );
  }
?>