<?php
  /**
   * @package   Event
   * @class     EventListener
   * @author    Jimmy
   * @date      29 oct. 06
   * @brief     Classe concr�te pour �couteur d'�v�nement
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
    /** @brief    IEventDispatcher    Cible de l'�coute*/
    private $_ItsTarget;
    public function __construct( IEventDispatcher &$dispatcher ) {
      $this->_ItsTarget =& $dispatcher;
    }

    /**
     * @brief   Retourne la cible de l'�coute
     * @return  IEventDispatcher
     * @note    Correspond � la source des �v�nements diffus�s
     */
    public function &getTarget() { return $this->_ItsTarget; }

    /**
     * @brief   M�thode recevant les �v�nements et redispatchant aux m�thodes qui conviennent
     * @param   $eventName    string    nom de l'�v�nement
     * @param   $oEvent       IEvent    l'�v�nement � dispatcher
     * @param   $args         mixed     arguments pour mode push
     * @return  void
     * @note    C'est ici que r�side la magie : )
     */
    public function handleEvent( $eventName, IEvent &$oEvent, $args = null ) {
      if ( method_exists( $this, 'on'.$eventName ) ) {
        call_user_func_array( array( $this, 'on'.$eventName ), array( $oEvent, $args ) );
      }
    }
  }
?>