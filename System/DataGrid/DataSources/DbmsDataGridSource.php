<?php
  /**
   * @package     	DataGrid
   * @class       	DbmsDataGridSource
   * @author      	Jimmy CHARLEBOIS
   * @date        	20-11-2006
   * @brief       	Implémentation de source de données MySQL pour DataGrid
   */
  System::import( 'System.DataSource.DbmsDataSource' );
  System::import( 'System.DataGrid.Model.DataGrid' );
  System::import( 'System.DataGrid.Model.DataGridRow' );
  System::import( 'System.DataGrid.Model.DataGridColumn' );
  System::import( 'System.DataGrid.DataSources.DataGridSource' );

  class DbmsDataGridSource extends DataGridSource {
    public function __construct( IDataSourceDriver $driver ) {
      parent::__construct( $driver );
    }

    public function dispose() {
      $db =& DbmsDataSource::getInstance( $this->getDriver() );
      $db->close();
    }

    public function &getDataGrid( IDataSourceExpression &$expression ) {
      $rv = null;
      if ( !$expression instanceof DbmsExpression )
        throw new Exception( 'DbmsExpression missing' );

      $db =& DbmsDataSource::getInstance( $this->getDriver() );
      if ( $rs =& $db->execute( $expression->toString() ) ) {
        $dgr_id = $dg_row = null;
        while( $row =& $rs->next() ) {
          if ( is_null( $rv ) ) {
            $rv =& new DataGrid( $this, $row[ 'datagrid_id' ] );
            $rv->setTitle( $row[ 'datagrid_title' ] );
          }
          if ( $dgr_id != $row[ 'datagridrow_id' ] ) {
            if ( !is_null( $dg_row ) )
              $rv->add( $dg_row );
            $dg_row =& new DataGridRow( $row[ 'datagridrow_id' ] );
          }

          $dg_row->add( new DataGridColumn( $row[ 'datagridcolumn_id' ], $row[ 'datagridcolumn_value' ] ) );

          $dgr_id = $row[ 'datagridrow_id' ];
        }
        $rs->dispose();
      }
      if ( !is_null( $dg_row ) )
        $rv->add( $dg_row );

      $db->close();
      return $rv;
    }
  }
?>