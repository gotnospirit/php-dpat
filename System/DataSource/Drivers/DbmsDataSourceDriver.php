<?php
  /**
   * @package     	DataSource
   * @class       	DbmsDataSourceDriver
   * @author      	Jimmy CHARLEBOIS
   * @date        	20-11-2006
   * @brief       	Décorateur de DataSourceDriver pour base de données
   */
  System::import( 'System.Interfaces.DataSource.IDataSourceDriver' );

  class DbmsDataSourceDriver implements IDataSourceDriver {
    private $_driver;

    private $_dbUsername;
    private $_dbPasswd;
    private $_dbHost;
    private $_dbName;

    public function __construct( IDataSourceDriver &$driver ) {
      $this->_driver =& $driver;

      $matches = array();
      preg_match( '~([a-z0-9_-]+):([a-z0-9_-]+)@([a-z0-9_-]+)\.([a-z0-9_-]+)~i', $driver->getDomain(), $matches );
      if ( 5 != count( $matches ) )
        throw new Exception( 'Cannot parse driver\'s domain for dbms context' );
      else {
        $this->_dbUsername = $matches[ 1 ];
        $this->_dbPasswd = $matches[ 2 ];
        $this->_dbHost = $matches[ 3 ];
        $this->_dbName = $matches[ 4 ];
      }
    }

    public function getScheme() { return $this->_driver->getScheme(); }

    public function getDomain() { return $this->_driver->getDomain(); }

    public function getParameter() { return $this->_driver->getParameter(); }

    public function toString() {
      return $this->_driver->toString();
    }

    /**
     * @brief   Retourne l'identifiant de connexion
     * @return  string
     */
    public function getUsername() { return $this->_dbUsername; }

    /**
     * @brief   Retourne le mot de passe associé à l'identifiant de connexion
     * @return  string
     */
    public function getPassword() { return $this->_dbPasswd; }

    /**
     * @brief   Retourne le nom du serveur de bdd
     * @return  string
     */
    public function getHost() { return $this->_dbHost; }

    /**
     * @brief   Retourne le nom de la base de données visée
     * @return  string
     */
    public function getDbName() { return $this->_dbName; }
  }
?>