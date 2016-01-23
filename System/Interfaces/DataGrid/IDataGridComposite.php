<?php
  /**
   * @package       DataGrid
   * @interface     IDataGridComposite
   * @author        Jimmy CHARLEBOIS
   * @date          10-11-2006
   * @brief         Interface pour composé d'un DataGrid
   * @note          Devrait peut être céder la place à la classe abstraite car on est déjà spécialisé (DataGrid)
   * @note          Par contre peut être devrait-on introduire une interface généraliste IComposite & IComponent
   */
  System::import( 'System.Interfaces.MVC.IModel' );

  interface IDataGridComposite extends IModel {
    /**
     * @brief   Ajoute un composant au composé
     * @param   $oComponent   IDataGridComponent
     * @return  boolean
     */
    public function add( IDataGridComponent &$oComponent );

    /**
     * @brief   Retourne la collection des composants
     * @return  array
     */
    public function &getComponents();
  }
?>