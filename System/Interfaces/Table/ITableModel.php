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
     * @brief   Retourne le nombre de colonne pr�sentes dans le mod�le
     * @return  integer
     */
    public function getColumnCount();

    /**
     * @brief   Retourne le libell� associ�e � une colonne
     * @param   $columnIndex    integer   le num�ro de la colonne
     * @return  string
     */
    public function getColumnName( $columnIndex );

    /**
     * @brief   Retourne le nombre de lignes pr�sentes dans le mod�le
     * @return  integer
     */
    public function getRowCount();

    /**
     * @brief   Retourne la valeur de la cellule � la colonne et la ligne d�sign�e
     * @param   $rowIndex       integer   le num�ro de la ligne
     * @param   $columnIndex    integer   le num�ro de la colonne
     * return   IADT
     */
    public function &getValueAt( $rowIndex, $columnIndex );

    /**
     * @brief   Retourne la valeur de la cellule � la colonne et la ligne d�sign�e
     * @param   $value          IADT      la valeur de la cellule
     * @param   $rowIndex       integer   le num�ro de la ligne
     * @param   $columnIndex    integer   le num�ro de la colonne
     * return   ADT
     */
    public function setValueAt( IADT &$value, $rowIndex, $columnIndex );

    /**
     * @brief   Retourne la valeur de la cellule � la colonne et la ligne d�sign�e
     * @param   $rowIndex       integer   le num�ro de la ligne
     * @param   $columnIndex    integer   le num�ro de la colonne
     * @return  boolean
     */
    public function isCellEditable( $rowIndex, $columnIndex );
  }
?>