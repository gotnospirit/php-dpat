<?php
  /**
   * @package     	Table
   * @interface     ITableModel
   * @author      	Jimmy CHARLEBOIS
   * @date        	28-02-2007
   * @brief       	
   */
  System::import( 'System.Interfaces.MVC.IModel' );

  interface ITableModel extends IModel {
//    public function addTableModelListener( ITableListener &$listener );
//    public function removeTableModelListener( ITableListener &$listener );

    /**
     * @brief   Retourne le nombre de colonne présentes dans le modèle
     * @return  integer
     */
    public function getColumnCount();

    /**
     * @brief   Retourne le libellé associée à une colonne
     * @param   $columnIndex    integer   le numéro de la colonne
     * @return  string
     */
    public function getColumnName( $columnIndex );

    /**
     * @brief   Retourne le nombre de lignes présentes dans le modèle
     * @return  integer
     */
    public function getRowCount();

    /**
     * @brief   Retourne la valeur de la cellule à la colonne et la ligne désignée
     * @param   $rowIndex       integer   le numéro de la ligne
     * @param   $columnIndex    integer   le numéro de la colonne
     * return   IADT
     */
    public function &getValueAt( $rowIndex, $columnIndex );

    /**
     * @brief   Retourne la valeur de la cellule à la colonne et la ligne désignée
     * @param   $value          IADT      la valeur de la cellule
     * @param   $rowIndex       integer   le numéro de la ligne
     * @param   $columnIndex    integer   le numéro de la colonne
     * return   ADT
     */
    public function setValueAt( IADT &$value, $rowIndex, $columnIndex );

    /**
     * @brief   Retourne la valeur de la cellule à la colonne et la ligne désignée
     * @param   $rowIndex       integer   le numéro de la ligne
     * @param   $columnIndex    integer   le numéro de la colonne
     * @return  boolean
     */
    public function isCellEditable( $rowIndex, $columnIndex );
  }
?>