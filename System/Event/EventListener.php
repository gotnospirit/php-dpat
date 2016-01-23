<?php
  /**
   * @package   Event
   * @class     EventListener
   * @author    Jimmy
   * @date      29 oct. 06
   * @brief     Classe concrête pour écouteur d'évènement
   * @code		
   *  class CollectionListener extends EventListener {
   *    public function onAdd( IEvent &$oEvent, $args = null ) {
   *      System::export( $oEvent->getSource()->getClassname().'->add( '.$oEvent->getContext().' );' );
   *    }
   *  }
   *  ...
   *  $oStack->addEventListener( new CollectionListener( $oStack ) );
   * @endcode
   */
  System::import( 'System.Interfaces.Event.IEventListener' );

  class EventListener implements IEventListener {
    /** @brief    IEventDispatcher    Cible de l'écoute*/
    private $_ItsTarget;
    public function __construct( IEventDispatcher &$dispatcher ) {
      $this->_ItsTarget =& $dispatcher;
    }

    /**
     * @brief   Retourne la cible de l'écoute
     * @return  IEventDispatcher
     * @note    Correspond à la source des évènements diffusés
     */
    public function &getTarget() { return $this->_ItsTarget; }

    /**
     * @brief   Méthode recevant les évènements et redispatchant aux méthodes qui conviennent
     * @param   $eventName    string    nom de l'évènement
     * @param   $oEvent       IEvent    l'évènement à dispatcher
     * @param   $args         mixed     arguments pour mode push
     * @return  void
     * @note    C'est ici que réside la magie : )
     */
    public function handleEvent( $eventName, IEvent &$oEvent, $args = null ) {
      if ( method_exists( $this, 'on'.$eventName ) ) {
        call_user_func_array( array( $this, 'on'.$eventName ), array( $oEvent, $args ) );
      }
    }
  }
?>