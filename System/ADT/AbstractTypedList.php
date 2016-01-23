<?php
  /**
   * @package       ADT
   * @class         AbstractTypedList
   * @author        Jimmy CHARLEBOIS
   * @date          21-02-2007
   * @brief         Classe abstraite pour gérer des List avec des éléments typés
   * @example       adt-typedlist-loader.php
   */
  System::import( 'System.Interfaces.ADT.IList' );
  System::import( 'System.ADT.AbstractTypedCollection' );
  System::import( 'System.Exceptions.TypeMismatchException' );

  abstract class AbstractTypedList extends AbstractTypedCollection implements IList {
    protected function __construct( $type, IList &$list ) {
      parent::__construct( $type, $list );
    }

    public function set( $index, $o ) {
      if ( !is_a( $o, $this->_type ) )
        throw new TypeMismatchException( sprintf( 'Argument must be an instance of %s object', $this->_type ) );
      $this->_collection->set( $index, $o );
    }

    public function &get( $index ) {
      return $this->_collection->get( $index );
    }

    public function indexOf( $o ) {
      if ( !is_a( $o, $this->_type ) )
        throw new TypeMismatchException( sprintf( 'Argument must be an instance of %s object', $this->_type ) );
      return $this->_collection->indexOf( $o );
    }

    public function lastIndexOf( $o ) {
      if ( !is_a( $o, $this->_type ) )
        throw new TypeMismatchException( sprintf( 'Argument must be an instance of %s object', $this->_type ) );
      return $this->_collection->lastIndexOf( $o );
    }
  }
?>