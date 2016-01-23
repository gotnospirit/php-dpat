<?php
  /**
   * @package     	ADT
   * @interface     IQueue
   * @author      	Jimmy CHARLEBOIS
   * @date        	19-02-2007
   * @brief       	Interface pour file d'attente du type FIFO
   */
  System::import( 'System.Interfaces.ADT.IList' );

  interface IQueue extends IList {
    /**
     * @brief   Supprime l'élément en premier dans la collection
     * @return  boolean
     */
    public function dequeue();

    /**
     * @brief   Ajoute un élément à la collection
     * @param   $element    mixed   l'élément à ajouter
     * @return  void
     */
    public function enqueue( $element );

    /**
     * @brief   Retourne l'élément en premier dans la collection
     * @return  mixed
     */
    public function peek();

    /**
     * @brief   Retourne l'élément en premier dans la collection et le supprime de celle-ci
     * @return  mixed
     */
    public function poll();
  }
?>