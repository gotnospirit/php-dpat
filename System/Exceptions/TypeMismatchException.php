<?php
  /**
   * @package       Exceptions
   * @class         TypeMismatchException
   * @author        Jimmy CHARLEBOIS
   * @date          19-02-2007
   * @brief         Exception lancée lorsque le type d'un objet n'est pas valide
   */
  class TypeMismatchException extends Exception {
    public function __construct( $msg = null ) {
      $msg = ( is_null( $msg ) )
        ? 'Type mismatch' : 'Type mismatch : '.$msg;
      parent::__construct( $msg );
    }
  }
?>