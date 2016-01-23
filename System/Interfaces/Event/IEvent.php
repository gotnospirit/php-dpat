<?php
  /**
   * @interface IEvent
   * @author    Jimmy CHARLEBOIS
   * @date      29-10-2006
   * @brief     Interface à implémenter par les objets évènements
   */

  interface IEvent {
    public function setBubble( $value );
    public function getBubble();

    public function getName();

    public function &getSource();
    public function setSource( IEventDispatcher &$oSource );

    public function &getContext();
  }
?>