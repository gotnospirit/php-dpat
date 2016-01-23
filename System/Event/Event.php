<?php
  /**
   * @package   Event
   * @class     Event
   * @author    Jimmy CHARLEBOIS
   * @date      29 oct. 06
   * @brief     Objet évènement
   */
  System::import( 'System.Interfaces.Event.IEvent' );

  class Event implements IEvent {
    private $_name;
    private $_source;
    private $_bubble;
    private $_context;

    public function __construct( $eventName, IEventDispatcher &$oSource, $context = null, $bubble = true ) {
      $this->_name = $eventName;
      $this->_source =& $oSource;
      $this->_bubble = $bubble;
      $this->_context =& $context;
    }

    /**
     * @brief   Définit si l'évènement peut être dispatcher verticalement dans la hiérarchie des écouteurs
     * @param   $value    boolean
     * @return  void
     */
    public function setBubble( $value ) { $this->_bubble = $value; }
    /**
     * @brief   Indique si l'évènement peut être dispatcher verticalement
     * @return  boolean
     */
    public function getBubble() { return $this->_bubble; }

    /**
     * @brief   Retourne le nom de l'évènement
     */
    public function getName() { return $this->_name; }

    /**
     * @brief   Retourne la source de l'évènement (l'objet émetteur)
     * @return  IEventDispatcher
     */
    public function &getSource() { return $this->_source; }
    /**
     * @brief   Définit la source de l'évènement
     * @param   $oSource    IEventDispatcher
     * @warning Cette méthode ne devrait pas être appelée par un script utilisateur
     * @note    Invoquée lors du dispatching vertical
     */
    public function setSource( IEventDispatcher &$oSource ) { $this->_source =& $oSource; }

    /**
     * @brief   Retourne le contexte associé à l'évènement
     * @note    un contexte ici est en fait un objet de configuration pour mode push 
     */
    public function &getContext() { return $this->_context; }
  }
?>