<?php
  /**
   * @package     Context
   * @class       ShellContext
   * @author      Jimmy CHARLEBOIS
   * @date        16-11-2006
   * @brief       Contexte d'exécution en mode shell
   */
  System::import( 'System.Context.Context' );

  class ShellContext extends Context {
    public function __construct() {
      parent::__construct();

      if ( array_key_exists( 'argv', $_SERVER ) ) {
        foreach( $_SERVER[ 'argv' ] AS $key => $value )
          $this->setParam( $key, $this->cleanString( $value ) );
      }
    }
  }
?>