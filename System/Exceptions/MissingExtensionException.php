<?php
  /**
   * @package       Exceptions
   * @class         MissingExtensionException
   * @author        Jimmy CHARLEBOIS
   * @date          07-03-2007
   * @brief         Exception lancée lorsqu'une extension php est manquante
   */
  class MissingExtensionException extends Exception {
    public function __construct( $msg = null ) {
      $msg = ( is_null( $msg ) )
        ? 'Missing extension' : 'Missing extension : '.$msg;
      parent::__construct( $msg );
    }
  }
?>