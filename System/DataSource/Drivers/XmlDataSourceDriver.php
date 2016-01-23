<?php
  /**
   * @package     	DataSource
   * @class       	XmlDataSourceDriver
   * @author      	Jimmy CHARLEBOIS
   * @date        	20-11-2006
   * @brief       	Décorateur de DataSourceDriver pour fichier XML
   */

  class XmlDataSourceDriver implements IDataSourceDriver {
    private $_driver;

    public function __construct( IDataSourceDriver &$driver ) {
      $this->_driver =& $driver;
    }

    public function getScheme() { return $this->_driver->getScheme(); }

    public function getDomain() { return $this->_driver->getDomain(); }

    public function getParameter() { return $this->_driver->getParameter(); }

    public function toString() {
      return $this->_driver->toString();
    }

    /**
     * @brief   Retourne le chemin du fichier XML visé par le driver
     * @return  string
     */
    public function getFilepath() {
      return $this->_driver->getDomain();
    }
  }
?>