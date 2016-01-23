<?php
  /**
   * @package       Exceptions
   * @class         IOException
   * @author        Jimmy CHARLEBOIS
   * @date          13-04-2007
   * @brief         Exception lanc�e pour probl�mes d'entr�e/sortie
   */
  class IOException extends Exception {
    public function __construct( $msg ) {
      parent::__construct( $msg );
    }
  }
?>