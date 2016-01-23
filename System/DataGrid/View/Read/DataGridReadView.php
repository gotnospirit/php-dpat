<?php
  /**
   * @package     DataGrid
   * @class       DataGridReadView
   * @author      Jimmy CHARLEBOIS
   * @date        10-11-2006
   * @brief       Vue en mode consultation d'un DataGrid
   */
  System::import( 'System.MVC.AbstractView' );
  System::import( 'System.DataGrid.View.Read.DataGridRowReadView' );

  class DataGridReadView extends AbstractView {
    public function __construct( IDataGridComposite &$datagrid ) {
      parent::__construct();
      $this->setModel( $datagrid );
    }

    public function display() {
      $rows = $this->getModel()->getComponents();
      echo '<div class="datagrid read">', System::crlf
        , '<table border="1" cellspacing="0" cellpadding="0">', System::crlf;
      if ( !is_null( $this->getModel()->getTitle() ) )
        echo '<caption>', $this->getModel()->getTitle(), '</caption>', System::crlf;
      echo '<tbody>', System::crlf;
      foreach( $rows AS $rowId => $row ) {
        $dgrView =& new DataGridRowReadView( $row );
        $dgrView->display();
      }
      echo '</tbody>', System::crlf
        , '</table>', System::crlf
        , '<a href="?datagrid-id='.urlencode( $this->getModel()->getId() ).'&datagrid-mode=edit">Edit</a>', System::crlf
        , '</div>', System::crlf
        ;
    }
  }
?>