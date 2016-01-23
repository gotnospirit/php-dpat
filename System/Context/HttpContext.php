<?php
  /**
   * @package       Context
   * @class         HttpContext
   * @author        Jimmy CHARLEBOIS
   * @date          16-11-2006
   * @brief         Contexte d'exécution pour le protocole HTTP
   */
  System::import( 'System.Context.Context' );

  class HttpContext extends Context {
    public function __construct() {
      parent::__construct();

      foreach( $_SERVER AS $key => $value )
        $this->setParam( $key, $this->cleanArray( $value ) );
      foreach( $_POST AS $key => $value )
        $this->setParam( $key, $this->cleanArray( $value ) );
      foreach( $_FILES AS $key => $value )
        $this->setParam( $key, $this->cleanArray( $value ) );
      foreach( $_GET AS $key => $value )
        $this->setParam( $key, $this->cleanArray( $value ) );
    }
  }
?>