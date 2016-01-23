<?php
  /**
   * @package       DataGrid
   * @class         DataGridColumnEditView
   * @author        Jimmy CHARLEBOIS
   * @date          16-11-2006
   * @brief         Vue en mode édition d'une "cellule" d'un enregistrement de DataGrid
   */
  System::import( 'System.MVC.AbstractView' );
  System::import( 'System.Interfaces.MVC.IView' );

  class DataGridColumnEditView extends AbstractView {
    public function __construct( IDataGridComponent &$datagridcolumn ) {
      parent::__construct();
      $this->setModel( $datagridcolumn );
    }

    public function display() {
      $columnInputName = 'datagrid['.$this->getModel()->getParent()->getId().']['.$this->getModel()->getId().']';
      echo '<td><input type="text" name="', $columnInputName, '" value="', htmlspecialchars( $this->getModel()->getValue() ), '" /></td>', System::crlf;
    }
  }
?>