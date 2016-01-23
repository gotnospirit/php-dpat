<?php
  /**
   * @package       DataGrid
   * @class         DataGridColumn
   * @author        Jimmy CHARLEBOIS
   * @date          10-11-2006
   * @brief         
   */
  System::import( 'System.Interfaces.DataGrid.IDataGridComponent' );

  class DataGridColumn implements IDataGridComponent {
    private $_id;
    private $_value;
    private $_parent;

    public function __construct( $id, $value = null ) {
      $this->_id = $id;
      $this->_value = $value;
      $this->_parent = null;
    }

    public function getId() { return $this->_id; }

    public function &getValue() { return $this->_value; }

    public function &getParent() { return $this->_parent; }

    public function setParent( IDataGridComposite &$dgComposite ) {
      $this->_parent =& $dgComposite;
    }
  }
?>