<?php
  /**
   * @package     DataGrid
   * @class       DataGridRowReadView
   * @author      Jimmy CHARLEBOIS
   * @date        10-11-2006
   * @brief       Vue en mode consultation d'un enregistrement de DataGrid
   */
  System::import( 'System.MVC.AbstractView' );
  System::import( 'System.DataGrid.View.Read.DataGridColumnReadView' );

  class DataGridRowReadView extends AbstractView {
    private $_datagridrow;

    public function __construct( IDataGridComposite &$datagridrow ) {
      parent::__construct();
      $this->_datagridrow =& $datagridrow;
    }

    public function display() {
      $columns = $this->_datagridrow->getComponents();
      echo '<tr>', System::crlf
        , '<th>', $this->_datagridrow->getId(),'</th>', System::crlf;
      foreach( $columns AS $columnId => $column ) {
        $dgcView =& new DataGridColumnReadView( $column );
        $dgcView->display();
      }
      echo '</tr>', System::crlf;
    }
  }
?>