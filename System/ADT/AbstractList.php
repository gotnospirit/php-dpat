<?php
  /**
   * @package     	ADT
   * @class       	AbstractList
   * @author      	Jimmy CHARLEBOIS
   * @date        	21-02-2007
   * @brief       	Classe abstraite pour les collections des valeurs
   */
  System::import( 'System.Interfaces.ADT.IList' );
  System::import( 'System.ADT.AbstractCollection' );
  System::import( 'System.Exceptions.IllegalArgumentException' );

  abstract class AbstractList extends AbstractCollection implements IList {
    protected function __construct() {
      parent::__construct();
    }

    public function set( $index, $o ) {
      if ( !is_int( $index ) )
        throw new IllegalArgumentException();
      if ( $index < 0 || $index >= $this->size() )
        throw new OutOfBoundsException();
      $this->_values[ $index ] =& $o;
    }

    public function &get( $index ) {
      $rv = null;
      foreach( $this->_values AS $key => $value )
        if ( $index == $key ) {
          $rv =& $value;
          break;
        }
      return $rv;
    }

    public function indexOf( $o ) {
      $rv = null;
      foreach( $this->_values AS $index => $value )
        if ( $o == $value ) {
          $rv = $index;
          break;
        }
      return $rv;
    }

    public function lastIndexOf( $o ) {
      $rv = null;
      foreach( $this->_values AS $index => $value )
        if ( $o == $value )
          $rv = $index;
      return $rv;
    }
  }
?>