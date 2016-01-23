<?php
  /**
   * @package     	ADT
   * @class       	SortedSet
   * @author      	Jimmy CHARLEBOIS
   * @date        	22-02-2007
   * @brief       	Classe pour collection de valeurs triées
   * @example       adt-treeset-loader.php
   */
  System::import( 'System.Interfaces.ADT.ISortedSet' );
  System::import( 'System.ADT.AbstractSet' );
  System::import( 'System.ADT.Iterators.SetIterator' );

  class TreeSet extends AbstractSet implements ISortedSet {
    private $_comparator;

    public function __construct( IComparator &$comparator = null ) {
      parent::__construct();
      $this->_comparator = $comparator;
    }

    public function add( $o ) {
      if ( !is_a( $o, 'IComparable' ) )
        throw new IllegalArgumentException( 'Argument must implement IComparable interface' );
      if ( $this->isEmpty( $o ) )
        return parent::add( $o );

      return parent::add( $o );
    }

    public function getIterator() {
      return new SetIterator( $this );
    }

    public function getComparator() {
      return $this->_comparator;
    }

    public function first() {
      return min( $this->_values );
    }

    public function &headSet( $to_element ) {
    }

    public function last() {
      return max( $this->_values );
    }

    public function &subSet( $from_element, $to_element ) {
    }

    public function &tailSet( $from_element ) {
    }
  }
?>