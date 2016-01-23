<?php
  /**
   * @interface IEventDispatcher
   * @author    Jimmy CHARLEBOIS
   * @date      29-10-2006
   * @brief     Interface de marquage à implémenter par les objets souhaitant diffuser leurs évènements
   */

  interface IEventDispatcher {
    /**
     * @brief   Inscrit un écouteur
     * @param   $oListener    IEventListener    l'écouteur que l'on souhaite inscrire
     * @return  void
     */
    public function addEventListener( IEventListener &$oListener );

    /**
     * @brief   Supprime un écouteur
     * @param   $oListener    IEventListener    l'écouteur à désincrire
     * @return  void
     */
    public function removeEventListener( IEventListener &$oListener );

    /**
     * @brief   Supprime tous les écouteurs
     * @return  void
     */
    public function removeAllEventListeners();

    /**
     * @brief   Dispatche un évènement aux écouteurs inscrit
     * @param   $oEvent   IEvent    l'évènement à dispatcher
     * @return  void
     */
    public function dispatch( IEvent &$oEvent );
  }
?>