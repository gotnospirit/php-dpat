<?php
  /**
   * @package     DataSource
   * @class       DataSourceDriver
   * @author      Jimmy CHARLEBOIS
   * @date        10-11-2006
   * @brief       Driver générique pour DataSource
   */
  System::import( 'System.Interfaces.DataSource.IDataSourceDriver' );

  class DataSourceDriver implements IDataSourceDriver {
    private $_scheme;
    private $_domain;
    private $_param;

    private function __construct( $scheme, $domain, $param ) {
      $this->_scheme = $scheme;
      $this->_domain = $domain;
      $this->_param = $param;
    }

    public function getScheme() { return $this->_scheme; }

    public function getDomain() { return $this->_domain; }

    public function getParameter() { return $this->_param; }

    public function toString() {
      return sprintf( '%s://%s/%s', $this->_scheme, $this->_domain, $this->_param );
    }

    /**
     * @brief   Crée un driver d'après la signature fournie
     * @param   $signature    string    la signature décrivant la config du driver souhaité
     * @return  DataSourceDriver
     */
    public function &createNew( $signature ) {
      $rv = null;
      $matches = array();
      preg_match( '~([a-z]+)://([a-z0-9\.@:]+)(?:/(.*))?~i', $signature, $matches );
      if ( count( $matches ) < 3 )
        throw new Exception( 'Unparseable driver signature' );
      $rv =& new DataSourceDriver( $matches[ 1 ], $matches[ 2 ], $matches[ 3 ] );
      return $rv;
    }
  }
?>