<?php
  /**
   * @package     	Exceptions
   * @class       	UnsupportedOperationException
   * @author      	Jimmy CHARLEBOIS
   * @date        	19-02-2007
   * @brief       	Exception lanc�e lorsqu'un objet ne g�re pas une m�thode
   */
  class UnsupportedOperationException extends Exception {
    public function __construct( $msg = null ) {
      $msg = ( is_null( $msg ) )
        ? 'Unsupported operation' : 'Unsupported operation : '.$msg;
      parent::__construct( $msg );
    }
  }
?>