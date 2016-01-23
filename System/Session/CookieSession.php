<?php
  /**
   * @package     	Session
   * @class       	CookieSession
   * @author      	Jimmy CHARLEBOIS
   * @date        	11-04-2007
   * @brief       	Implémentation de ISession utilisant un cookie sur le poste client
   */
  System::import( 'System.Interfaces.Session.ISession' );
  System::import( 'System.Exceptions.UnsupportedOperationException' );

  class CookieSession implements ISession {
    private static $_secretsalt = 'The Cookie Secret Salt';

    public static $timeout = null;
    public static $encode = true;

    public static function start() {
      throw new UnsupportedOperationException( 'Cookie didn\'t need to be started' );
    }

    public static function getUID() {
      throw new UnsupportedOperationException( 'No UID for Cookie' );
    }

    /**
     * @brief   Génère un checksum pour l'encodage des valeurs du cookie
     * @param   $data   string    la valeur de la variable
     * @return  string
     */
    private static function getChecksum( $data ) {
      return md5( $data.md5( self::$_secretsalt ) );
    }

    public static function exists( $key ) {
      return !is_null( self::get( $key ) );
    }

    public static function &get( $key ) {
      $rv = null;
      if ( isset( $_COOKIE[ $key ] ) && mb_strlen( $_COOKIE[ $key ] ) > 0 ) {
        $var = @unserialize( $_COOKIE[ $key ] );
        if ( $var === false )
          $rv = $_COOKIE[ $key ];
        else {
          list( $data, $chksum ) = $var;
          if ( self::getChecksum( $data ) == $chksum )
            $rv = unserialize( $data ); // Data is valid
        }
      }
      return $rv;
    }

    public static function set( $key, $value ) {
      if ( !self::$encode )
        $data = $value;
      else {
        $data = serialize( $value );
        $chksum = self::getChecksum( $data );
        $var = serialize( array( $data, $chksum ) );
      }

      if ( self::$timeout != 0 )
        self::$timeout += time();

      if ( headers_sent() )
        throw new RuntimeException( 'Unable to write cookie data : headers already sent' );
      $rv = setcookie( $key, $var, self::$timeout, '/' );
      if ( $rv )
        $_COOKIE[ $key ] = $var;
      return $rv;
    }

    public static function delete( $key ) {
      if ( headers_sent() )
        throw new RuntimeException( 'Unable to delete cookie data : headers already sent' );
      $rv = setcookie( $key, null, time()-1, '/' );
      if ( $rv )
        unset( $_COOKIE[ $key ] );
      return $rv;
    }
  }
?>