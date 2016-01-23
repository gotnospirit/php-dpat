<?php
  /**
   * @package     DataGrid
   * @class       DataGridRowEditView
   * @author      Jimmy CHARLEBOIS
   * @date        16-11-2006
   * @brief       Vue en mode édition d'un enregistrement de DataGrid
   */
  System::import( 'System.MVC.AbstractView' );
  System::import( 'System.DataGrid.View.Edit.DataGridColumnEditView' );

  class DataGridRowEditView extends AbstractView {
    public function __construct( IDataGridComposite &$datagridrow ) {
      parent::__construct();
      $this->setModel( $datagridrow );
    }

    public function display() {
      $columns = $this->getModel()->getComponents();
      echo '<tr>', System::crlf
        , '<th>', $this->getModel()->getId(),'</th>', System::crlf;
      foreach( $columns AS $columnId => $column ) {
        $dgcView =& new DataGridColumnEditView( $column );
        $dgcView->display();
      }
      echo '</tr>', System::crlf;
    }
  }
?>