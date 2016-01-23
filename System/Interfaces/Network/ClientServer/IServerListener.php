<?php
  /**
   * @package     	Network.ClientServer
   * @interface     IServerListener
   * @author      	Jimmy CHARLEBOIS
   * @date        	24-04-2007
   * @brief       	
   */
  System::import( 'System.Interfaces.Event.IEventListener' );

  interface IServerListener extends IEventListener {
    public function onTimeout( IEvent &$e, $args = null );
    public function onError( IEvent &$e, $args = null );
    public function onBeforeClose( IEvent &$e, $args = null );
    public function onStart( IEvent &$e, $args = null );
    public function onClose( IEvent &$e, $args = null );
    public function onClientRemoved( IEvent &$e, $args = null );
    public function onClientArrival( IEvent &$e, $args = null );
  }
?>