<?php
  /**
   * @package     	Caddy
   * @class       	CaddyItem
   * @author      	Jimmy CHARLEBOIS
   * @date        	06-03-2007
   * @brief       	
   */
  System::import( 'System.Interfaces.Caddy.ICaddyItem' );
  System::import( 'System.Interfaces.Iteration.IIterable' );
  System::import( 'System.Caddy.Iterators.CaddyItemIterator' );
  System::import( 'System.Exceptions.TypeMismatchException' );
  System::import( 'System.BaseClass' );
  System::import( 'System.StoreObject' );

  class CaddyItem extends BaseClass implements ICaddyItem, IIterable {
    private $_key;
    private $_quantity;
    private $_price;
    private $_features;

    public function __construct( $key, $quantity, $price ) {
      parent::__construct();
      $this->_key = $key;
      $this->_quantity = $quantity;
      $this->_price = $price;
      $this->_features = array();
    }

    public function getKey() {
      return $this->_key;
    }

    public function getQuantity() {
      return $this->_quantity;
    }
    public function setQuantity( $value ) {
      if ( !is_numeric( $value ) )
        throw new TypeMismatchException( 'Le prix doit être une valeur numérique' );
      $this->_quantity = $value;
    }

    public function getPrice() {
      return $this->_price;
    }
    public function setPrice( $value ) {
      if ( !is_numeric( $value ) )
        throw new TypeMismatchException( 'Le prix doit être une valeur numérique' );
      $this->_price = $value;
    }

    public function addCaddyItemFeature( ICaddyItemFeature &$feat ) {
      $this->_features[ $feat->getKey() ] =& $feat;
    }
    public function removeCaddyItemFeature( ICaddyItemFeature &$feat ) {
      if ( array_key_exists( $feat->getKey(), $this->_features ) ) {
        unset( $this->_features[ $feat->getKey() ] );
        return true;
      }
      return false;
    }

    public function size() {
      return count( $this->_features );
    }

    public function toArray() {
      $rv = array();
      foreach( $this->_features AS $idx => $value )
        $rv[] =& $this->_features[ $idx ];
      return $rv;
    }

    public function equals( ICaddyItem &$item ) {
      if ( $item->getKey() != $this->_key )
        return false;
      if ( $item->getQuantity() != $this->_quantity )
        return false;
      if ( $item->getPrice() != $this->_price )
        return false;
      /** @note   On pourrait tester aussi les caractéristiques */
      return true;
    }

    public function getIterator() {
      return new CaddyItemIterator( $this );
    }

    public function store() {
      $feat_data = array();
      foreach( $this->_features AS $idx => $feat )
        $feat_data[ $idx ] = StoreObject::store( $this->_features[ $idx ] );
      return array(
        'key' => $this->_key,
        'quantity' => $this->_quantity,
        'price' => $this->_price,
        'features' => $feat_data
      );
    }

    public static function restore( $props ) {
      $rv =& new CaddyItem( $props[ 'key' ], $props[ 'quantity' ], $props[ 'price' ] );
      foreach( $props[ 'features' ] AS $key => $value )
        $rv->addCaddyItemFeature( StoreObject::restore( $value ) );
      return $rv;
    }
  }
?>