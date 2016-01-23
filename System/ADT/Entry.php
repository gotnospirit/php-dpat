<?php
  /**
   * @package     	ADT
   * @class       	Entry
   * @author      	Jimmy CHARLEBOIS
   * @date        	21-02-2007
   * @brief       	Abstraction d'une entrée dans une collection de type Map
   * @relates       Map
   */

  class Entry {
    private $_key;
    private $_value;

    public function __construct( $key, $value ) {
      $this->_key = $key;
      $this->_value =& $value;
    }

    public function getKey() {
      return $this->_key;
    }

    public function getValue() {
      return $this->_value;
    }

    public function setValue( $value ) {
      $this->_value =& $value;
    }
  }
?>