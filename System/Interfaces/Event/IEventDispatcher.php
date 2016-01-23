<?php
  /**
   * @interface IEventDispatcher
   * @author    Jimmy CHARLEBOIS
   * @date      29-10-2006
   * @brief     Interface de marquage � impl�menter par les objets souhaitant diffuser leurs �v�nements
   */

  interface IEventDispatcher {
    /**
     * @brief   Inscrit un �couteur
     * @param   $oListener    IEventListener    l'�couteur que l'on souhaite inscrire
     * @return  void
     */
    public function addEventListener( IEventListener &$oListener );

    /**
     * @brief   Supprime un �couteur
     * @param   $oListener    IEventListener    l'�couteur � d�sincrire
     * @return  void
     */
    public function removeEventListener( IEventListener &$oListener );

    /**
     * @brief   Supprime tous les �couteurs
     * @return  void
     */
    public function removeAllEventListeners();

    /**
     * @brief   Dispatche un �v�nement aux �couteurs inscrit
     * @param   $oEvent   IEvent    l'�v�nement � dispatcher
     * @return  void
     */
    public function dispatch( IEvent &$oEvent );
  }
?>