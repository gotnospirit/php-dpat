<?php
  /**
   * @package       Network.Http
   * @class         HttpMessage
   * @author        Jimmy CHARLEBOIS
   * @date          14-02-2007
   * @brief         Classe sous jacente encapsulant un message HTTP (requête ou réponse)
   */
  System::import( 'System.Interfaces.Network.IHttpMessage' );

  class HttpMessage implements IHttpMessage {
    private $_type;
    private $_url;
    private $_method;
    private $_version;
    private $_raw;
    private $_headers;
    private $_body;
    private $_querystring;
    private $_response_code;
    private $_response_statut;

    const EOL       = "\r\n";

    /** @defgroup   HttpMessageType   Constantes pour les méthodes d'envoi d'un message Http */
    /*@{*/
    const REQUEST   = 1;
    const RESPONSE  = 2;
    /*@}*/

    /** @defgroup   HttpMessageMethod   Constantes pour les méthodes d'envoi d'un message Http */
    /*@{*/
    const METHOD_POST = 'post';
    const METHOD_GET  = 'get';
    /*@}*/

    /** @defgroup   HttpMessageVersion    Constantes pour indiquer la version du protocole à utiliser pour le message Http */
    /*@{*/
    const VERSION_1_0   = 'HTTP/1.0';
    const VERSION_1_1   = 'HTTP/1.1';
    /*@}*/

    public function __construct( $type, $url, $method = self::METHOD_GET ) {
      $this->setUrl( $url );
      $this->setMethod( $method );
      $this->_type = $type;
      $this->_headers = array();
      $this->_version = self::VERSION_1_0;
      $this->_body = null;
      $this->_querystring = array();
      $this->_raw = null;
      $this->_response_code = null;
      $this->_response_statut = null;
    }

    /**
     * @brief   Retourne le type du message
     * @return  \ref HttpMessageType
     */
    public function getType() {
      return $this->_type;
    }

    /** @brief    Implémentation de l'interface IHttpMessage  */
    /*@{*/
    public function setUrl( $url ) {
      $this->_url = $url;
    }
    public function getUrl() {
      return $this->_url;
    }

    public function setMethod( $method ) {
      $allowed = array( self::METHOD_POST, self::METHOD_GET );
      if ( !in_array( $method, $allowed ) )
        throw new Exception( 'Unsupported request method' );
      $this->_method = $method;
    }
    public function getMethod() {
      return $this->_method;
    }

    public function addHeader( $key, $value ) {
      $this->_headers[ $key ] = $value;
    }
    public function getHeaders() {
      return $this->_headers;
    }

    public function setVersion( $version ) {
      $allowed = array( self::VERSION_1_0, self::VERSION_1_1 );
      if ( !in_array( $version, $allowed ) )
        throw new Exception( 'Unsupported protocole version' );
      $this->_version = $version;
    }
    public function getVersion() {
      return $this->_version;
    }

    public function setQueryString( $value ) {
      if ( !is_array( $value ) )
        throw new Exception( 'The parameter must be an array' );
      $this->_querystring = $value;
    }
    public function getQueryString() {
      return $this->_querystring;
    }

    public function setRaw( $raw ) {
      $this->_raw = $raw;
    }
    public function getRaw() {
      return $this->_raw;
    }

    public function setBody( $body ) {
      $this->_body = $body;
    }
    public function getBody() {
      return $this->_body;
    }

    public function setResponseCode( $code ) {
      if ( strlen( $code ) != 3 )
        throw new Exception( 'Wrong response code format' );
      $this->_response_code = $code;
    }
    public function getResponseCode() {
      return $this->_response_code;
    }

    public function setResponseStatut( $statut ) {
      $this->_response_statut = $statut;
    }
    public function getResponseStatut() {
      return $this->_response_statut;
    }
    /*@{*/

    public function __toString() {
      return $this->getRaw();
    }
  }
?>