<?php
  /**
   * @package       DataGrid
   * @class         XmlDataGridSource
   * @author        Jimmy CHARLEBOIS
   * @date          10-11-2006
   * @brief         
   */
  System::import( 'System.DataGrid.DataSources.DataGridSource' );
  System::import( 'System.DataSource.Drivers.XmlDataSourceDriver' );
  System::import( 'System.DataGrid.Model.DataGrid' );
  System::import( 'System.DataGrid.Model.DataGridRow' );
  System::import( 'System.DataGrid.Model.DataGridColumn' );

  class XmlDataGridSource extends DataGridSource {
    private $_xpathExpression;

    public function __construct( IDataSourceDriver $driver ) {
      parent::__construct( new XmlDataSourceDriver( $driver ) );
      if ( !function_exists( 'simplexml_load_file' ) )
        throw new Exception( 'SimpleXML is required !' );

      $this->_xpathExpression = $driver->getParameter();
    }

    public function dispose()
    {}

    public function &getDataGrid( IDataSourceExpression &$expression ) {
      $driver =& $this->getDriver();
      $xml = simplexml_load_file( $driver->getFilepath() );
      if ( !$xml )
        throw new Exception( 'Unable to load `'.$driver->getFilepath().'`' );
      if ( !$expression instanceof XpathExpression )
        throw new Exception( 'Missing XPath expression' );
      $xpathResult = $xml->xpath( $expression->toString() );
      if ( count( $xpathResult ) != 1 )
        throw new Exception( 'XPath expression returns more than one root element' );
      $rv =& new DataGrid( $this, (string)$xpathResult[ 0 ][ 'id' ] );
      $rv->setTitle( (string)$xpathResult[ 0 ][ 'title' ] );
      foreach( $xpathResult[ 0 ]->datagridrow AS $idx => $dgRow ) {
        $oDGR =& new DataGridRow( (string)$dgRow[ 'id' ] );
        foreach( $dgRow->datagridcolumn AS $idx => $dgColumn )
          $oDGR->add( new DataGridColumn( (string)$dgColumn[ 'id' ], (string)$dgColumn ) );
        $rv->add( $oDGR );
      }
      return $rv;
    }
  }
?>