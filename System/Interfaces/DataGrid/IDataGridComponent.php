<?php
  /**
   * @package       DataGrid
   * @interface     IDataGridComponent
   * @author        Jimmy CHARLEBOIS
   * @date          10-11-2006
   * @brief         Interface pour composant d'un DataGrid
   * @note          Devrait peut �tre c�der la place � la classe abstraite car on est d�j� sp�cialis� (DataGrid)
   * @note          Par contre peut �tre devrait-on introduire une interface g�n�raliste IComposite & IComponent
   */
  System::import( 'System.Interfaces.MVC.IModel' );

  interface IDataGridComponent extends IModel {
    /**
     * @brief   Retourne l'identifiant du composant
     * @return  string
     */
    public function getId();

    /**
     * @brief   Retourne la valeur du composant
     * @return  mixed
     */
    public function &getValue();

    /**
     * @brief   Retourne le compos� parent du composant
     * @return  IDataGridComposite
     */
    public function &getParent();
  }
?>