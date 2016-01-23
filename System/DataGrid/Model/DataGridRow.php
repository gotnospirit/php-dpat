<?php
  /**
   * @package     DataGrid
   * @class       DataGridRow
   * @author      Jimmy CHARLEBOIS
   * @date        10-11-2006
   * @brief       Classe de marquage d'un enregistrement du DataGrid
   */
  System::import( 'System.DataGrid.Model.DataGridComposite' );

  class DataGridRow extends DataGridComposite {
    public function __construct( $id ) {
      parent::__construct( $id );
    }
  }
?>