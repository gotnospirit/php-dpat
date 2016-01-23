<?php
  /**
   * @package       ADT
   * @class         Hashtable
   * @author        Jimmy CHARLEBOIS
   * @date          21-02-2007
   * @brief         Implémentation d'une collection associant clés et valeurs
   * @example       adt-hashtable-loader.php
   */
  System::import( 'System.ADT.AbstractMap' );
  System::import( 'System.ADT.Iterators.MapIterator' );

  class Hashtable extends AbstractMap {
    public function __construct() {
      parent::__construct();
    }

    public function getIterator() {
      return new MapIterator( $this );
    }
  }
?>