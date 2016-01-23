<?php
  /**
   * @package       DataGrid
   * @class   		DataGridComposite
   * @author        Jimmy CHARLEBOIS
   * @date          10-11-2006
   * @brief         
   */
  System::import( 'System.Interfaces.DataGrid.IDataGridComposite' );
  System::import( 'System.Interfaces.DataGrid.IDataGridComponent' );

  abstract class DataGridComposite implements IDataGridComposite, IDataGridComponent {
    private $_id;
    private $_parent;
    private $_components;

    public function __construct( $id ) {
      $this->_id = $id;
      $this->_parent = null;
      $this->_components = array();
    }

    public function getId() { return $this->_id; }

    public function &getValue() {
      throw new Exception( 'Unsupported operation' );
    }

    public function &getParent() { return $this->_parent; }

    public function setParent( IDataGridComposite &$dgComposite ) {
      $this->_parent =& $dgComposite;
    }

    public function add( IDataGridComponent &$oComponent ) {
      if ( array_key_exists( $oComponent->getId(), $this->_components ) )
        return false;
      $this->_components[ $oComponent->getId() ] =& $oComponent;
      $oComponent->setParent( $this );
      return true;
    }

    public function &getComponents() { return $this->_components; }
  }
?>