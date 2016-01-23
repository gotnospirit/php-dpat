<?php
  /**
   * @interface IEventListener
   * @author    Jimmy CHARLEBOIS
   * @date      29-10-2006
   * @brief     Interface pour les objets �couteurs d'�v�nements
   */

  interface IEventListener {
    public function &getTarget();
    public function handleEvent( $eventName, IEvent &$oEvent, $args = null);
  }
?>