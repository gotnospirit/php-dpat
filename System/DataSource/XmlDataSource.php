<?php
  /**
   * @package       DataSource
   * @class         XmlDataSource
   * @author        Jimmy CHARLEBOIS
   * @date          07-03-2007
   * @brief         
   */
  System::import( 'System.DataSource.DataSource' );
  System::import( 'System.DataSource.Drivers.XmlDataSourceDriver' );
  System::import( 'System.Event.Event' );
  System::import( 'System.Xml.xmlDocument' );

  class XmlDataSource extends DataSource {
    private $_resource;

    public function __construct( IDataSourceDriver $driver ) {
      parent::__construct( new XmlDataSourceDriver( $driver ) );
      $this->_resource = null;
    }

    /**
     * @brief   Définit la ressource php à utiliser pour la connexion
     * @param   $res    resource    resource php issu d'un *_connect
     * @return  void
     */
    public function setResource( &$res ) {
      $this->_resource =& $res;
    }

    /**
     * @brief   Retourne la ressource php associée à la connexion
     * @return  resource
     */
    public function &getResource() {
      return $this->_resource;
    }

    /**
     * @brief   Définit la resource et s'y connecte si besoin
     * @return  boolean
     * @throw   Exception
     */
    public function connect() {
      try {
        $this->setResource( xmlDocument::loadFile( $this->getDriver()->getFilepath() ) );
      } catch( FileNotFoundException $e ) {
        $this->dispatch( new Event( 'StorageError', $this ) );
      }
    }

    /**
     * @brief   Libère la resource
     * @return  boolean
     */
    public function close() {
      $this->_resource = null;
    }

    public function dispose() {
      return $this->close();
    }
  }
?>