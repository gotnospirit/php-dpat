<?php
  /**
   * @package     	Log
   * @class       	ListenableLog
   * @author      	Jimmy CHARLEBOIS
   * @date        	24-01-2007
   * @brief       	Décorateur permettant d'écouter un fichier de journalisation
   * @code
   *   class LogListener extends EventListener {
   *    public function onWrite( IEvent &$oEvent, $args = null ) {
   *      echo $oEvent->getContext()."\n";
   *    }
   *   }
   *   ...
   *   $log =& new ListenableLog( new FileLog( 'test.log' ) );
   *   $log->addEventListener( new LogListener( $log ) );
   *   $log->write( 'Un message à logguer !' );
   *   $log->dispose();
   * @endcode
   * @example       core-log-loader.php
   */
  System::import( 'System.Interfaces.Log.ILog' );
  System::import( 'System.Interfaces.IResource' );
  System::import( 'System.Interfaces.Event.IEventDispatcher' );

  System::import( 'System.BaseClass' );
  System::import( 'System.Event.Event' );
  System::import( 'System.Event.EventDispatcher' );

  class ListenableLog extends BaseClass implements ILog, IResource, IEventDispatcher {
    private $_log;
    private $_evtDispatcher;

    public function __construct( ILog &$log ) {
      $this->_log =& $log;
      $this->_evtDispatcher = new EventDispatcher();
    }

    /** @brief    Implémentation de l'interface IEventDispatcher par délégation */
    /*@{*/
    public function addEventListener( IEventListener &$oListener ) {
      $this->_evtDispatcher->addEventListener( $oListener );
    }
    public function removeEventListener( IEventListener &$oListener ) {
      $this->_evtDispatcher->removeEventListener( $oListener );
    }
    public function dispatch( IEvent &$oEvent ) {
      $this->_evtDispatcher->dispatch( $oEvent );
    }
    /*@}*/

    /** @brief    Implémentation de l'interface IResource */
    /*@{*/
    public function dispose() {
      $this->_log->dispose();
    }
    /*@}*/

    /** @brief    Implémentation de l'interface ILog par délégation */
    /*@{*/
    public function write( $data ) {
      $rv = $this->_log->write( $data );
      if ( $rv )
        $this->_evtDispatcher->dispatch( new Event( 'write', $this, $data ) );
      return $rv;
    }
    /*@}*/
  }
?>