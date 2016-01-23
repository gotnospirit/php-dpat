<?php
  /**
   * @package     	Caddy
   * @class       	Caddy
   * @author      	Jimmy CHARLEBOIS
   * @date        	06-03-2007
   * @brief       	
   */
  System::import( 'System.Interfaces.Caddy.ICaddy' );
  System::import( 'System.Interfaces.Iteration.IIterable' );
  System::import( 'System.Interfaces.MVC.IModel' );
  System::import( 'System.Caddy.Iterators.CaddyIterator' );
  System::import( 'System.BaseClass' );
  System::import( 'System.StoreObject' );

  class Caddy extends BaseClass implements ICaddy, IIterable, IModel {
    private $_items;

    public function __construct() {
      parent::__construct();
      $this->_items = array();
    }

    public function addCaddyItem( ICaddyItem &$item ) {
      $this->_items[] =& $item;
    }

    public function removeCaddyItem( ICaddyItem &$item ) {
      foreach( $this->_items AS $idx => $caddyItem )
        if ( $caddyItem->equals( $item ) ) {
          unset( $this->_items[ $idx ] );
          break;
        }
      return false;
    }

    public function &getCaddyItem( $itemKey ) {
      $rv = null;
      foreach( $this->_items AS $idx => $item )
        if ( $itemKey == $item->getKey() ) {
          $rv =& $this->_items[ $idx ];
          break;
        }
      return $rv;
    }

    public function clear() {
      $this->_items = array();
    }

    public function size() {
      return count( $this->_items );
    }

    public function toArray() {
      $rv = array();
      foreach( $this->_items AS $idx => $value )
        $rv[] =& $this->_items[ $idx ];
      return $rv;
    }

    public function getIterator() {
      return new CaddyIterator( $this );
    }

    public function store() {
      $item_data = array();
      foreach( $this->_items AS $idx => $item )
        $item_data[ $idx ] = StoreObject::store( $this->_items[ $idx ] );
      return array(
        'items' => $item_data
      );
    }

    public static function restore( $props ) {
      $rv =& new Caddy();
      foreach( $props[ 'items' ] AS $key => $value )
        $rv->addCaddyItem( StoreObject::restore( $value ) );
      return $rv;
    }
  }
?>