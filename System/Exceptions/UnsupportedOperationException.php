<?php
  /**
   * @package     	Exceptions
   * @class       	UnsupportedOperationException
   * @author      	Jimmy CHARLEBOIS
   * @date        	19-02-2007
   * @brief       	Exception lancée lorsqu'un objet ne gère pas une méthode
   */
  class UnsupportedOperationException extends Exception {
    public function __construct( $msg = null ) {
      $msg = ( is_null( $msg ) )
        ? 'Unsupported operation' : 'Unsupported operation : '.$msg;
      parent::__construct( $msg );
    }
  }
?>