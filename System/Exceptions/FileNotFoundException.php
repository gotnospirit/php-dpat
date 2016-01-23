<?php
  /**
   * @package       Exceptions
   * @class         FileNotFoundException
   * @author        Jimmy CHARLEBOIS
   * @date          08-03-2007
   * @brief         Exception lancée lorsqu'un fichier ne peut être trouvé
   */
  class FileNotFoundException extends Exception {
    public function __construct( $msg = null ) {
      $msg = ( is_null( $msg ) )
        ? 'File not found' : 'File not found : '.$msg;
      parent::__construct( $msg );
    }
  }
?>