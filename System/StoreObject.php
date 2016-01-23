<?php
  /**
   * @package       Base
   * @class       	StoreObject
   * @author      	Jimmy CHARLEBOIS
   * @date        	14-02-2007
   * @brief       	Cette classe permet de stocker/recréer des objets implémentant IStorable
   */

  class StoreObject {
    public static function store( &$obj ) {
      if ( is_null( $obj ) || !is_a( $obj, 'IStorable' ) )
        return null;
      return serialize( array(
        'class' => $obj->getClassname(),
        'props' => $obj->store()
      ) );
    }

    public static function restore( $msg ) {
      if ( is_null( $msg ) )
        return null;
      $rv = @unserialize( $msg );
      if ( $rv === false || !is_array( $rv ) )
        throw new TypeMismatchException( 'Couldn\'t restore structure' );
      return call_user_func_array( array( $rv[ 'class' ], 'restore' ), array( $rv[ 'props' ] ) );
    }
  }
?>