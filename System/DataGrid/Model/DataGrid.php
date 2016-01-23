<?php
  /**
   * @package   	DataGrid
   * @class   		DataGrid
   * @author        Jimmy CHARLEBOIS
   * @date          10-11-2006
   * @brief         Classe de marquage du DataGrid
   */
  System::import( 'System.DataGrid.Model.DataGridComposite' );

  class DataGrid extends DataGridComposite {
    private $_datasource;
    private $_title;

    public function __construct( IDataSource &$datasource, $id ) {
      parent::__construct( $id );
      $this->_datasource =& $datasource;
      $this->_title = null;
    }

    public function setTitle( $title ) {
      $this->_title = $title;
    }

    public function getTitle() {
      return $this->_title;
    }

    /**
     * @brief   Retourne une copie du driver ayant servi à créer le DataGrid
     * @return  IDataSourceDriver
     */
    public function getSourceDriver() {
      return $this->_datasource->getDriver();
    }
  }
?>