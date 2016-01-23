<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          23-01-2007
   * @brief         Exemple d'utilisation d'un fichier de journalisation
   */
  require 'c.system.php';

  System::import( 'System.IO.Log.FileLog' );
  System::import( 'System.IO.Log.ListenableLog' );
  System::import( 'System.IO.Log.LogListener' );

  /**
   * @internal
   */
  class MyLogListener extends LogListener {
    public function onWrite( IEvent &$oEvent, $args = null ) {
      echo $oEvent->getContext()."\n";
    }
  }

  Header( 'Content-Type: text/plain; charset="windows-1252"' );
  Header( 'Content-Disposition: inline' );

  $log =& new ListenableLog( new FileLog( 'test.log' ) );
  $log->addEventListener( new MyLogListener( $log ) );
  $log->write( 'Un message à logguer !' );
  $log->dispose();
?>