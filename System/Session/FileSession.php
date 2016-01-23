<?php
  /**
   * @package       Session
   * @class         FileSession
   * @author        Jimmy CHARLEBOIS
   * @date          10-12-2006
   * @brief         Implémentation de ISession utilisant directement le tableau $_SESSION
   */
  System::import( 'System.Interfaces.Session.ISession' );

  class FileSession implements ISession {
    public static function start() {
      return session_start();
    }

    public static function exists( $key ) {
      return !is_null( self::get( $key ) );
    }

    public static function &get( $key ) {
      $rv = null;
      if ( isset( $_SESSION[ $key ] ) )
        $rv =& $_SESSION[ $key ];
      return $rv;
    }

    public static function set( $key, $value ) {
      $_SESSION[ $key ] =& $value;
      return true;
    }

    public static function getUID() {
      return session_id();
    }

    public static function delete( $key ) {
      $_SESSION[ $key ] = null;
      return true;
    }
  }
?>