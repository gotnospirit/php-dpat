<?php
  /**
   * @package       Caddy
   * @class         CaddyItemFeature
   * @author        Jimmy CHARLEBOIS
   * @date          06-03-2007
   * @brief         
   */
  System::import( 'System.Interfaces.Caddy.ICaddyItemFeature' );
  System::import( 'System.BaseClass' );
  System::import( 'System.StoreObject' );

  class CaddyItemFeature extends BaseClass implements ICaddyItemFeature {
    private $_key;
    private $_value;

    public function __construct( $key, $value ) {
      parent::__construct();
      $this->_key = $key;
      $this->_value = $value;
    }

    public function getKey() {
      return $this->_key;
    }

    public function getValue() {
      return $this->_value;
    }
    public function setValue( $value ) {
      $this->_value = $value;
    }

    public function store() {
      $value = $this->_value;
      if ( is_a( $value, 'IStorable' ) )
        $value = StoreObject::store( $value );
      return array(
        'key' => $this->_key,
        'value' => $value
      );
    }

    public static function restore( $props ) {
      try {
        $value = StoreObject::restore( $props[ 'value' ] );
      } catch( TypeMismatchException $e ) {
        $value = $props[ 'value' ];
      }
      return new CaddyItemFeature( $props[ 'key' ], $value );
    }
  }
?>