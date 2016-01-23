<?php
  /**
   * @package       DataGrid
   * @interface     IDataGridComponent
   * @author        Jimmy CHARLEBOIS
   * @date          10-11-2006
   * @brief         Interface pour composant d'un DataGrid
   * @note          Devrait peut être céder la place à la classe abstraite car on est déjà spécialisé (DataGrid)
   * @note          Par contre peut être devrait-on introduire une interface généraliste IComposite & IComponent
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
     * @brief   Retourne le composé parent du composant
     * @return  IDataGridComposite
     */
    public function &getParent();
  }
?>