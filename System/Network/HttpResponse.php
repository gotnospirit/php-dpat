<?php
  /**
   * @package     	Network.Http
   * @class       	HttpResponse
   * @author      	Jimmy CHARLEBOIS
   * @date        	14-02-2007
   * @brief       	Classe encapsulant une réponse HTTP
   */
  System::import( 'System.Interfaces.Network.IHttpMessage' );
  System::import( 'System.Network.HttpMessage' );

  class HttpResponse implements IHttpMessage {
    private $_message;

    public function __construct( $url, $method ) {
      $this->_message =& new HttpMessage( HttpMessage::RESPONSE, $url, $method );
    }

    /** @brief    Implémentation de l'interface IHttpMessage par déléguation  */
    /*@{*/
    public function setUrl( $url ) {
      $this->_message->setUrl( $url );
    }
    public function getUrl() {
      return $this->_message->getUrl();
    }
    public function setMethod( $method ) {
      $this->_message->setMethod( $method );
    }
    public function getMethod() {
      return $this->_message->getMethod();
    }
    public function setVersion( $version ) {
      $this->_message->setVersion( $version );
    }
    public function getVersion() {
      return $this->_message->getVersion();
    }
    public function addHeader( $key, $value ) {
      $this->_message->addHeader( $key, $value );
    }
    public function getHeaders() {
      return $this->_message->getHeaders();
    }
    public function setQueryString( $value ) {
      $this->_message->setQueryString( $value );
    }
    public function getQueryString() {
      return $this->_message->getQueryString();
    }
    public function setRaw( $raw ) {
      $this->_message->setRaw( $raw );
    }
    public function getRaw() {
      return $this->_message->getRaw();
    }
    public function setBody( $body ) {
      $this->_message->setBody( $body );
    }
    public function getBody() {
      return $this->_message->getBody();
    }
    public function setResponseCode( $code ) {
      return $this->_message->setResponseCode( $code );
    }
    public function getResponseCode() {
      return $this->_message->getResponseCode();
    }
    public function setResponseStatut( $statut ) {
      return $this->_message->setResponseStatut( $statut );
    }
    public function getResponseStatut() {
      return $this->_message->getResponseStatut();
    }
    /*@{*/

    public function __toString() {
      return (string)$this->_message;
    }

    public function parse( $rawResponse ) {
      $this->setRaw( $rawResponse );

      $tmp = explode( HttpMessage::EOL.HttpMessage::EOL, $rawResponse );
      if ( count( $tmp ) > 0 ) {
        if ( isset( $tmp[ 1 ] ) )
          $this->setBody( trim( $tmp[ 1 ] ) );

        $tmp = explode( HttpMessage::EOL, $tmp[ 0 ] );

        $tmpStatut = array_shift( $tmp );
        if ( !is_null( $tmpStatut ) ) {
          $tmpStatut = explode( ' ', $tmpStatut );
          $this->setVersion( array_shift( $tmpStatut ) );
          $this->setResponseCode( array_shift( $tmpStatut ) );
          $this->setResponseStatut( System::implode( $tmpStatut, ' ' ) );
        }

        $raw_headers = $tmp;
        foreach( $tmp AS $idx => $rawHeader ) {
          $tmpHeader = explode( ': ', $rawHeader );
          $this->addHeader( $tmpHeader[ 0 ], $tmpHeader[ 1 ] );
        }
      }
    }
  }
?>