<?php
  /**
   * @package     DataGrid
   * @class       DataGridEditView
   * @author      Jimmy CHARLEBOIS
   * @date        16-11-2006
   * @brief       Vue en mode édition d'un DataGrid
   */
  System::import( 'System.MVC.AbstractView' );
  System::import( 'System.DataGrid.View.Edit.DataGridRowEditView' );

  class DataGridEditView extends AbstractView {
    public function __construct( IDataGridComposite &$datagrid ) {
      parent::__construct();
      $this->setModel( $datagrid );
    }

    public function display() {
      $rows = $this->getModel()->getComponents();

      echo '<div class="datagrid edit">', System::crlf
        , '<form action="', $this->getController()->getContext()->getParam( 'PHP_SELF' ) ,'" method="post">', System::crlf
        , '<div class="properties">', System::crlf
        , '<input type="hidden" name="datagrid-id" value="', $this->getModel()->getId(), '" />', System::crlf
//        , '<input type="hidden" name="datagrid-driver" value="', $this->_datagrid->getSourceDriver()->toString(), '" />', System::crlf
        , '<input type="hidden" name="datagrid-mode" value="processInput" />', System::crlf
        , '</div>', System::crlf
        , '<table border="1" cellspacing="0" cellpadding="0">', System::crlf;
      if ( !is_null( $this->getModel()->getTitle() ) )
        echo '<caption>', $this->getModel()->getTitle(), '</caption>', System::crlf;
      echo '<tbody>', System::crlf;
      foreach( $rows AS $rowId => $row ) {
        $dgrView =& new DataGridRowEditView( $row );
        $dgrView->display();
      }
      echo '</tbody>', System::crlf
        , '</table>', System::crlf
        , '<div class="action_panel">', System::crlf
        , '<input type="submit" />', System::crlf
        , '</div>', System::crlf
        , '</form>', System::crlf
        , '<a href="?datagrid-id='.urlencode( $this->getModel()->getId() ).'&datagrid-mode=read">Read</a>', System::crlf
        , '</div>', System::crlf
        ;
    }
  }
?>