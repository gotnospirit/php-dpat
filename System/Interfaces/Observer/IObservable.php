<?php
  /**
   * @package     	Observer
   * @interface     IObservable
   * @author      	Jimmy CHARLEBOIS
   * @date        	10-05-2007
   * @brief       	
   */

  interface IObservable {
    public function hasObservers( $eventName = null );
    public function registerEvent( $eventName, &$callback );
    public function fireEvent( $eventName, &$context = null );
  }
?>