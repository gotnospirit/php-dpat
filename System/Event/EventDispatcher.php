<?php
  /**
   * @package   Event
   * @class     EventDispatcher
   * @author    Jimmy CHARLEBOIS
   * @date      29 oct. 06
   * @brief     Source d'évènements qui diffuse, des évènements, à des objets écouteurs
   */
  System::import( 'System.Interfaces.Event.IEventDispatcher' );

  class EventDispatcher implements IEventDispatcher {
    private $_eventListeners;
    private $_hasEventListeners;
    private $_parent;
    public $bubbleEvent;

    public function __construct() {
      $this->_eventListeners = array();
      $this->_hasEventListeners = false;
      $this->_parent = null;
      $this->bubbleEvent = true;
    }

    public function addEventListener( IEventListener &$oListener ) {
      if ( !in_array( $oListener, $this->_eventListeners ) )
        $this->_eventListeners[] =& $oListener;
      $this->_hasEventListeners = true;
    }

    public function removeEventListener( IEventListener &$oListener ) {
      foreach( $this->_eventListeners AS $idx => &$oEventListener )
        if ( $oEventListener == $oListener )
          unset( $this->_eventListeners[ $idx ] );
      if ( 0 == count( $this->_eventListeners ) )
        $this->_hasEventListeners = false;
    }

    public function removeAllEventListeners() {
      foreach( $this->_eventListeners AS $idx => &$oEventListener )
        unset( $this->_eventListeners[ $idx ] );
      $this->_hasEventListeners = false;
    }

    /**
     * @brief   Retourne l'objet "détenteur" du dispatcher
     * @return  IEventDispatcher
     * @note    Utilisé pour "bubbler" un évènement
     */
    public function &getParent() { return $this->_parent; }
    /**
     * @brief   Définit le parent
     * @param   $oParent    IEventDispatcher
     * @return  void
     */
    public function setParent( IEventDispatcher &$oParent ) { $this->_parent =& $oParent; }
    /**
     * @brief   Indique si on a définit un parent
     * @return  boolean
     */
    public function hasParent() { return !is_null( $this->_parent ); }

    public function dispatch( IEvent &$oEvent ) {
      $this->fireEvent( $oEvent->getName(), null, $oEvent );
    }

    /**
     * @brief   Lance un évènement aux écouteurs
     * @param   $eventName    string    nom de l'évènement
     * @param   $args         mixed     arguments (utilisé en mode push)
     * @param   $oEvent       IEvent    objet évènement
     * @note    à la différence de dispatch si l'on ne fournit pas d'objet implémentant IEvent, il sera créé
     * @note    à la place de $args on peut utilisé un objet context dans l'évènement
     */
    private function fireEvent( $eventName, $args = null, &$oEvent = null ) {
      if ( !$this->_hasEventListeners )
        return false;
      if ( is_null( $oEvent ) )
        $oEvent =& new Event( $eventName, $this, $args );
      foreach( $this->_eventListeners AS $idx => &$oEventListener ) {
//        $oEvent->setTarget( $oEventListener->getTarget() );
        $this->_eventListeners[ $idx ]->handleEvent( $eventName, $oEvent, $args );
      }
      if ( $this->bubbleEvent && $oEvent->getBubble() && $this->hasParent() ) {
        $oEvent->setSource( $this->getParent() );
        $this->getParent()->fireEvent( $eventName, $args, $oEvent );
      }
    }
  }
?>
