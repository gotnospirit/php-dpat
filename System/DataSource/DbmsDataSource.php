<?php
  /**
   * @package       DataSource
   * @class         DbmsDataSource
   * @author        Jimmy CHARLEBOIS
   * @date          20-11-2006
   * @brief         Classe abstraite pour source de donn�es de type DBMS
   */
  System::import( 'System.DataSource.DataSource' );
  System::import( 'System.DataSource.Drivers.DbmsDataSourceDriver' );

  abstract class DbmsDataSource extends DataSource {
    private $_resource;
    private static $_instances;

    public function __construct( IDataSourceDriver $driver ) {
      parent::__construct( new DbmsDataSourceDriver( $driver ) );
      $this->_resource = null;
    }

    /**
     * @brief   D�finit la ressource php � utiliser pour la connexion
     * @param   $res    resource    resource php issu d'un *_connect
     * @return  void
     */
    protected function setResource( &$res ) {
      $this->_resource =& $res;
    }

    /**
     * @brief   Retourne la ressource php associ�e � la connexion
     * @return  resource
     */
    public function &getResource() {
      return $this->_resource;
    }

    public function dispose() {
      return $this->close();
    }

    /**
     * @brief   Connecte l'instance au dbms
     * @return  boolean
     * @throw   Exception
     */
    abstract public function connect();

    /**
     * @brief   D�connecte l'instance du dbms
     * @return  boolean
     */
    abstract public function close();

    /**
     * @brief   Ex�cute une requ�te sql aupr�s du dbms
     * @param   $sql_request    string    la requ�te sql a ex�cuter
     * @return  IResultSet|boolean
     * @throw   Exception
     */
    abstract public function execute( $sql_request );

    /**
     * @brief   Retourne le dernier identifiant g�n�r� suite � une requ�te d'insertion
     * @return  integer|null
     */
    abstract public function getLastRowIdentifier();

    /**
     * @brief   Instancie la classe concr�te ad�quate pour le driver fournit
     * @param   $driver   IDataSourceDriver   driver de connexion
     * @return  DbmsDataSource
     */
    private static function createNew( IDataSourceDriver &$driver ) {
      $rv = null;
      if ( 'mysql' == $driver->getScheme() ) {
        System::import( 'System.DataSource.Dbms.DbmsMysql' );
        $rv =& new DbmsMysql( $driver );
      } else {
        throw new Exception( 'Unsupported dbms driver scheme' );
      }
      return $rv;
    }

    /**
     * @brief   Retourne une instance connect� au dbms correspondant au driver
     * @param   $driver   IDataSourceDriver   driver de connexion
     * @return  DbmsDataSource
     */
    public static function &getInstance( IDataSourceDriver &$driver ) {
      if ( is_null( self::$_instances ) )
        self::$_instances = array();
      $instance_key = $driver->getDomain();
      if ( !array_key_exists( $instance_key, self::$_instances ) )
        self::$_instances[ $instance_key ] =& self::createNew( $driver );
      self::$_instances[ $instance_key ]->connect();
      return self::$_instances[ $instance_key ];
    } 
  }
?>