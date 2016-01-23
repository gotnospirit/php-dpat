<?php
  /**
   * @package     	Log
   * @class       	LogListener
   * @author      	Jimmy CHARLEBOIS
   * @date        	24-01-2007
   * @brief       	Classe abstraite pour écouteur de fichier de journalisation écoutable
   */
  System::import( 'System.Event.EventListener' );

  abstract class LogListener extends EventListener {
    public function __construct( ListenableLog &$log ) {
      parent::__construct( $log );
    }

    abstract public function onWrite( IEvent &$oEvent, $args = null );
  }
?>