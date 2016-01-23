<?php
  /**
   * @package       ADT
   * @class         Set
   * @author        Jimmy CHARLEBOIS
   * @date          28-02-2007
   * @brief         Collection de valeurs ne pouvant contenir plusieurs fois le même élément
   */
  System::import( 'System.ADT.AbstractSet' );
  System::import( 'System.ADT.Iterators.SetIterator' );

  class Set extends AbstractSet {
    public function __construct() {
      parent::__construct();
    }

    public function getIterator() {
      return new SetIterator( $this );
    }
  }
?>