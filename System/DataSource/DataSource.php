<?php
  /**
   * @package     	DataSource
   * @class       	DataSource
   * @author      	Jimmy CHARLEBOIS
   * @date        	20-11-2006
   * @brief       	Implémentation abstraite d'une source de données
   */
  System::import( 'System.Interfaces.DataSource.IDataSource' );
  System::import( 'System.Event.EventDispatcher' );

  abstract class DataSource extends EventDispatcher implements IDataSource {
    private $_driver;

    public function __construct( IDataSourceDriver &$driver ) {
      parent::__construct();
      $this->_driver =& $driver;
    }

    public function getDriver() { return $this->_driver; }
  }
?>