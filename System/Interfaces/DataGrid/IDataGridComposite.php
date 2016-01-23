<?php
  /**
   * @package       DataGrid
   * @interface     IDataGridComposite
   * @author        Jimmy CHARLEBOIS
   * @date          10-11-2006
   * @brief         Interface pour compos� d'un DataGrid
   * @note          Devrait peut �tre c�der la place � la classe abstraite car on est d�j� sp�cialis� (DataGrid)
   * @note          Par contre peut �tre devrait-on introduire une interface g�n�raliste IComposite & IComponent
   */
  System::import( 'System.Interfaces.MVC.IModel' );

  interface IDataGridComposite extends IModel {
    /**
     * @brief   Ajoute un composant au compos�
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