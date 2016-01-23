<?php
  /**
   * @package     	Network.Http
   * @class       	HttpRequest
   * @author      	Jimmy CHARLEBOIS
   * @date        	14-02-2007
   * @brief       	Classe permettant d'envoyer un message HTTP
   * @example       component-httprequest-loader.php
   */
  System::import( 'System.Interfaces.Network.IHttpMessage' );
  System::import( 'System.Network.HttpMessage' );
  System::import( 'System.Network.HttpResponse' );

  class HttpRequest implements IHttpMessage {
    private $_message;
    private $_port;
    private $_timeout;

    public function __construct( $url, $method ) {
      $this->_message =& new HttpMessage( HttpMessage::REQUEST, $url, $method );
      $this->_port = 80;
      $this->_timeout = 60;
    }

    /**
     * @brief   Définit le port de communication vers l'url distante
     * @param   $port   integer   Le numéro du port
     * @return  void
     * @throw   Exception
     */
    public function setPort( $port ) {
      if ( !is_numeric( $port ) || is_float( $port ) || $port <= 0 || $port > 65535 )
        throw new Exception( 'Port number must be an integer (0>x>=65535)' );
      $this->_port = $port;
    }

    /**
     * @brief   Définit le temps d'attente
     * @param   $timeout   integer   Le temps d'attente maximale arrêt de la tentative de connexion
     * @return  void
     * @throw   Exception
     */
    public function setTimeout( $timeout ) {
      if ( !is_numeric( $timeout ) || is_float( $timeout ) )
        throw new Exception( 'Timeout must be an integer' );
      $this->_timeout = $timeout;
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
      throw new Exception( 'Illegal operation' );
    }
    public function getRaw() {
      return $this->_message->getRaw();
    }
    public function setBody( $body ) {
      throw new Exception( 'Illegal operation' );
    }
    public function getBody() {
      return $this->_message->getBody();
    }
    public function setResponseCode( $code ) {
      throw new Exception( 'Illegal operation' );
    }
    public function getResponseCode() {
      return $this->_message->getResponseCode();
    }
    public function setResponseStatut( $statut ) {
      throw new Exception( 'Illegal operation' );
    }
    public function getResponseStatut() {
      return $this->_message->getResponseStatut();
    }
    /*@{*/

    public function __toString() {
      return (string)$this->_message;
    }

    /**
     * @internal
     * @brief   Découpe l'url afin de déterminer ces composantes réseaux
     * @return  array
     */
    private function _parse_domain() {
      $rv = null;
      $matches = array();
      preg_match( '~([a-z]+://)([a-z0-9_\.-]+)/(.*)~i', $this->getUrl(), $matches );
      if ( count( $matches ) > 0 )
        $rv = array(
          'protocol' => $matches[ 1 ],
          'domain' => $matches[ 2 ],
          'uri' => $matches[ 3 ]
        );
      return $rv;
    }

    /**
     * @internal
     * @brief   Retourne la réponse Http
     * @return  HttpResponse
     */
    private function _get_httpresponse( &$connexion ) {
      $rv =& new HttpResponse( $this->getUrl(), $this->getMethod() );

      $reponse = '';
      while( !feof( $connexion ) )
        $reponse .= fgets( $connexion, 4096 );

      if ( '' != $reponse )
        $rv->parse( $reponse );
      return $rv;
    }

    /**
     * @brief   Envoi le message
     * @return  HttpResponse|null
     * @throw   Exception
     */
    public function send() {
      $rv = null;

      $tmp = $this->_parse_domain();
      $domain = $tmp[ 'domain' ];

      $errNumber = $errMessage = null;
      $connexion = @fsockopen( $domain, $this->_port, $errNumber, $errMessage, $this->_timeout );
      if ( !$connexion )
        throw new Exception( $errMessage, $errNumber );
      else {
        $uri = $tmp[ 'uri' ];

        $queryString = '';
        $qsParams = $this->getQueryString();
        if ( count( $qsParams ) > 0 ) {
          foreach( $qsParams AS $key => $value )
            if ( !is_array( $value ) && !is_object( $value ) ) {
//              if ( $this->getMethod() != HttpMessage::METHOD_POST )
                $value = urlencode( $value );
              $queryString .= $key.'='.$value.'&';
            } elseif ( is_array( $value ) ) {
              foreach( $value AS $k => $v )
                $queryString .= $key.'['.$k.']='.urlencode( $v ).'&';
            }
          $queryString = substr( $queryString, 0, -1 );
        }

        $request = '';

        if ( $this->getMethod() == HttpMessage::METHOD_POST ) {
          $this->addHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
          $this->addHeader( 'Content-Length', strlen( $queryString ) );
        } else {
          $uri .= '?'.$queryString;
        }

        $this->addHeader( 'Host', $domain );
        $this->addHeader( 'User-Agent', 'HttpRequest' );

        $request = strtoupper( $this->getMethod() ).' /'.$uri.' '.$this->getVersion().HttpMessage::EOL;

        $headers = $this->getHeaders();
        foreach( $headers AS $key => $value )
          $request .= $key.': '.$value.HttpMessage::EOL;
        if ( $this->getMethod() == HttpMessage::METHOD_POST )
          $request .= HttpMessage::EOL.$queryString;
        $request .= HttpMessage::EOL;
        $this->_message->setRaw( $request );

        fputs( $connexion, $request );
        $rv = $this->_get_httpresponse( $connexion );
        fclose( $connexion );
      }

      return $rv;
    }
  }
?>