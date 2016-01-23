<?php
  /**
   * @package     DataGrid
   * @class       DataGridColumnReadView
   * @author      Jimmy CHARLEBOIS
   * @date        10-11-2006
   * @brief       Vue en mode consultation d'une "cellule" d'un enregistrement de DataGrid
   */
  System::import( 'System.MVC.AbstractView' );

  class DataGridColumnReadView extends AbstractView {
    private $_datagridcolumn;

    public function __construct( IDataGridComponent &$datagridcolumn ) {
      parent::__construct();
      $this->_datagridcolumn =& $datagridcolumn;
    }

    public function display() {
      echo '<td>', $this->_datagridcolumn->getValue(), '</td>', System::crlf;
    }
  }
?>