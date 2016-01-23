<?php
  /**
   * @package   Event
   * @class     Event
   * @author    Jimmy CHARLEBOIS
   * @date      29 oct. 06
   * @brief     Objet �v�nement
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
     * @brief   D�finit si l'�v�nement peut �tre dispatcher verticalement dans la hi�rarchie des �couteurs
     * @param   $value    boolean
     * @return  void
     */
    public function setBubble( $value ) { $this->_bubble = $value; }
    /**
     * @brief   Indique si l'�v�nement peut �tre dispatcher verticalement
     * @return  boolean
     */
    public function getBubble() { return $this->_bubble; }

    /**
     * @brief   Retourne le nom de l'�v�nement
     */
    public function getName() { return $this->_name; }

    /**
     * @brief   Retourne la source de l'�v�nement (l'objet �metteur)
     * @return  IEventDispatcher
     */
    public function &getSource() { return $this->_source; }
    /**
     * @brief   D�finit la source de l'�v�nement
     * @param   $oSource    IEventDispatcher
     * @warning Cette m�thode ne devrait pas �tre appel�e par un script utilisateur
     * @note    Invoqu�e lors du dispatching vertical
     */
    public function setSource( IEventDispatcher &$oSource ) { $this->_source =& $oSource; }

    /**
     * @brief   Retourne le contexte associ� � l'�v�nement
     * @note    un contexte ici est en fait un objet de configuration pour mode push 
     */
    public function &getContext() { return $this->_context; }
  }
?>