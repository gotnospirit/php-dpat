<?php
  /**
   * @package       Exceptions
   * @class         IllegalArgumentException
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Exception lancée lorsqu'un argument n'est pas considéré comme valide
   */
  class IllegalArgumentException extends Exception {
    public function __construct( $msg = null ) {
      $msg = ( is_null( $msg ) )
        ? 'Illegal argument' : 'Illegal argument : '.$msg;
      parent::__construct( $msg );
    }
  }
?>