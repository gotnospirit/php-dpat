<?php
  /**
   * @package     	ADT
   * @class       	AbstractSet
   * @author      	Jimmy CHARLEBOIS
   * @date        	21-02-2007
   * @brief       	Classe abstraite pour collection de valeurs ne pouvant contenir plusieurs fois le même élément
   */
  System::import( 'System.ADT.AbstractCollection' );

  abstract class AbstractSet extends AbstractCollection {
    protected function __construct() {
      parent::__construct();
    }

    public function add( $o ) {
      if ( $this->contains( $o ) )
        return false;
      return parent::add( $o );
    }
  }
?>