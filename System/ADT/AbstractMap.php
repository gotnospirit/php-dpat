<?php
  /**
   * @package       ADT
   * @class         AbstractMap
   * @author        Jimmy CHARLEBOIS
   * @date          21-02-2007
   * @brief         Classe abstraite pour collections associants clés et valeurs
   */
  System::import( 'System.Interfaces.ADT.IADT' );
  System::import( 'System.Interfaces.ADT.IMap' );
  System::import( 'System.ADT.Entry' );
  System::import( 'System.ADT.Set' );

  abstract class AbstractMap implements IADT, IMap {
    protected $_values;

    protected function __construct() {
      $this->_values = array();
    }

    public function __toString() {
      $rv = '[';
      if ( !$this->isEmpty() ) {
        foreach( $this->_values AS $key => $value )
          $rv .= sprintf( '%s:%s', $key, (string)$value ).',';
        $rv = substr( $rv, 0, -1 );
      }
      $rv .= ']';
      return $rv;
    }

    public function &get( $key ) {
      $rv = null;
      foreach( $this->_values AS $k => $o )
        if ( $key == $k ) {
          $rv =& $o;
          break;
        }
      return $rv;
    }

    public function isEmpty() {
      return $this->size() == 0;
    }

    public function size() {
      return count( $this->_values );
    }

    public function toString() {
      return (string)$this;
    }

    public function toArray() {
      return $this->_values;
    }

    public function clear() {
      $this->_values = array();
    }

    public function containsKey( $key ) {
      return array_key_exists( $key, $this->_values );
    }

    public function containsValue( $value ) {
      return in_array( $value, $this->_values );
    }

    public function put( $key, $value ) {
      $rv = null;
      if ( $this->containsKey( $key ) )
        $rv =& $this->_values[ $key ];
      $this->_values[ $key ] =& $value;
      return $rv;
    }

    public function putAll( IMap $map ) {
      $items = $map->toArray();
      foreach( $items AS $key => $value )
        $this->put( $key, $value );
    }

    public function values() {
      return array_values( $this->toArray() );
    }

    public function entrySet() {
      $rv =& new Set();
      foreach( $this->_values AS $key => $value )
        $rv->add( new Entry( $key, $value ) );
      return $rv;
    }

    public function keySet() {
      $rv =& new Set();
      foreach( $this->_values AS $key => $value )
        $rv->add( $key );
      return $rv;
    }

    public function remove( $key ) {
      if ( $this->containsKey( $key ) )
        unset( $this->_values[ $key ] );
    }
  }
?>