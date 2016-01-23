<?php
  /**
   * @package     Context
   * @interface   IContext
   * @author      Jimmy CHARLEBOIS
   * @date        27-04-2007
   */
  interface IContext {
    /**
     * @brief   Retourne une collection des paramètres du contexte
     * @return  Hashtable
     */
    public function &getParams();

    /**
     * @brief   Indique si le paramètre existe dans le contexte
     * @param   $key    string    nom du paramètre
     * @return  boolean
     */
    public function hasParam( $key );

    /**
     * @brief   Retourne la valeur d'un paramètre du contexte
     * @param   $key    string    nom du paramètre
     * @return  mixed
     */
    public function &getParam( $key );
  }
?>