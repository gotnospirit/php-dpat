<?php
  /**
   * @package   Event
   * @class     EventDispatcher
   * @author    Jimmy CHARLEBOIS
   * @date      29 oct. 06
   * @brief     Source d'�v�nements qui diffuse, des �v�nements, � des objets �couteurs
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
     * @brief   Retourne l'objet "d�tenteur" du dispatcher
     * @return  IEventDispatcher
     * @note    Utilis� pour "bubbler" un �v�nement
     */
    public function &getParent() { return $this->_parent; }
    /**
     * @brief   D�finit le parent
     * @param   $oParent    IEventDispatcher
     * @return  void
     */
    public function setParent( IEventDispatcher &$oParent ) { $this->_parent =& $oParent; }
    /**
     * @brief   Indique si on a d�finit un parent
     * @return  boolean
     */
    public function hasParent() { return !is_null( $this->_parent ); }

    public function dispatch( IEvent &$oEvent ) {
      $this->fireEvent( $oEvent->getName(), null, $oEvent );
    }

    /**
     * @brief   Lance un �v�nement aux �couteurs
     * @param   $eventName    string    nom de l'�v�nement
     * @param   $args         mixed     arguments (utilis� en mode push)
     * @param   $oEvent       IEvent    objet �v�nement
     * @note    � la diff�rence de dispatch si l'on ne fournit pas d'objet impl�mentant IEvent, il sera cr��
     * @note    � la place de $args on peut utilis� un objet context dans l'�v�nement
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
