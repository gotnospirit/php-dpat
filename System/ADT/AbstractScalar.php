<?php
  /**
   * @package       ADT
   * @class         AbstractScalar
   * @author        Jimmy CHARLEBOIS
   * @date          21-02-2007
   * @brief         Classe abstraite pour les objets ADT scalaire
   */
  System::import( 'System.Interfaces.ADT.IADT' );
  System::import( 'System.Interfaces.Comparator.IComparable' );

  abstract class AbstractScalar implements IADT, IComparable {
    private $_value;
    protected function __construct( $value ) {
      $this->_value = $value;
    }

    public function getValue() {
      return $this->_value;
    }

    public function toString() {
      return (string)$this;
    }

    public function compareTo( IComparable $o ) {
      $rv = 0;
      if ( $this->getValue() < $o->getValue() )
        $rv = -1;
      elseif ( $this->getValue() > $o->getValue() )
        $rv = 1;
      return $rv;
    }

    abstract public function __toString();
  }
?>