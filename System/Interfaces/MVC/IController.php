<?php
  /**
   * @package       MVC
   * @interface     IController
   * @author        Jimmy CHARLEBOIS
   * @date          16-11-2006
   * @brief         Interface de controlleur
   */

  interface IController {
    /**
     * @brief   D�finit le mod�le du controlleur
     * @param   $model    IModel
     * @return  void
     * @throw   Exception
     */
    public function setModel( IModel &$model );

    /**
     * @brief   Retourne le mod�le du controlleur
     * @return  IModel
     */
    public function &getModel();

    /**
     * @brief   D�finit la vue du controlleur
     * @param   $view   IView
     * @return  void
     * @throw   Exception
     */
    public function setView( IView &$view );

    /**
     * @brief   Retourne la vue du controlleur
     * @return  IView
     */
    public function &getView();

    /**
     * @brief   Ex�cute le processus du controlleur
     * @return  void
     */
    public function process();
  }
?>