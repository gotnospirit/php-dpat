<?php
  /**
   * @package     	Table
   * @class       	AbstractTableModel
   * @author      	Jimmy CHARLEBOIS
   * @date        	28-02-2007
   * @brief       	
   */
  System::import( 'System.Interfaces.Table.ITableModel' );

  class AbstractTableModel implements ITableModel {
    private $_items;
    private $_columns;

    public function __construct( $items, $columnNames ) {
      $this->_items = $items;
      $this->_columns = $columnNames;
    }

    /**
     * @brief   Retourne l'index d'une colonne d'après son nom
     * @param   $columnName   string    Le nom de la colonne
     * @return  integer
     */
    public function findColumn( $columnName ) {
      $rv = -1;
      foreach( $this->_columns AS $index => $name )
        if ( $columnName == $name ) {
          $rv = $index;
          break;
        }
      return $rv;
    }

    public function getColumnCount() {
      return count( $this->_columns );
    }

    public function getColumnName( $columnIndex ) {
      $rv = null;
      if ( array_key_exists( $columnIndex, $this->_columns ) )
        $rv = $this->_columns[ $columnIndex ];
      return $rv;
    }

    public function getRowCount() {
      return count( $this->_items );
    }

    public function &getValueAt( $rowIndex, $columnIndex ) {
      $rv = null;
      if ( array_key_exists( $rowIndex, $this->_items ) && array_key_exists( $columnIndex, $this->_items[ $rowIndex ] ) )
        $rv =& $this->_items[ $rowIndex ][ $columnIndex ];
      return $rv;
    }

    public function setValueAt( IADT &$value, $rowIndex, $columnIndex ) {
      if ( $this->isCellEditable() )
        if ( array_key_exists( $rowIndex, $this->_items ) )
          $this->_items[ $rowIndex ][ $columnIndex ] =& $value;
    }

    /**
     * @note    Implémentation par défaut
     */
    public function isCellEditable( $rowIndex, $columnIndex ) {
      return false;
    }
  }
?>