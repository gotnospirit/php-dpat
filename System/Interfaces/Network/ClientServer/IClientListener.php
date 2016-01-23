<?php
  /**
   * @package       Network.ClientServer
   * @interface     IClientListener
   * @author        Jimmy CHARLEBOIS
   * @date          24-04-2007
   * @brief         
   */
  System::import( 'System.Interfaces.Event.IEventListener' );

  interface IClientListener extends IEventListener {
    public function onTimeout( IEvent &$e, $args = null );
    public function onRead( IEvent &$e, $args = null );
    public function onWrite( IEvent &$e, $args = null );
    public function onDisconnected( IEvent &$e, $args = null );
  }
?>