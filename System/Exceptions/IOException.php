<?php
  /**
   * @package       Exceptions
   * @class         IOException
   * @author        Jimmy CHARLEBOIS
   * @date          13-04-2007
   * @brief         Exception lancée pour problèmes d'entrée/sortie
   */
  class IOException extends Exception {
    public function __construct( $msg ) {
      parent::__construct( $msg );
    }
  }
?>