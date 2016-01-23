<?php
  /**
   * @interface IEvent
   * @author    Jimmy CHARLEBOIS
   * @date      29-10-2006
   * @brief     Interface � impl�menter par les objets �v�nements
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