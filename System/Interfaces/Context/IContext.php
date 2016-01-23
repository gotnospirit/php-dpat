<?php
  /**
   * @package     Context
   * @interface   IContext
   * @author      Jimmy CHARLEBOIS
   * @date        27-04-2007
   */
  interface IContext {
    /**
     * @brief   Retourne une collection des param�tres du contexte
     * @return  Hashtable
     */
    public function &getParams();

    /**
     * @brief   Indique si le param�tre existe dans le contexte
     * @param   $key    string    nom du param�tre
     * @return  boolean
     */
    public function hasParam( $key );

    /**
     * @brief   Retourne la valeur d'un param�tre du contexte
     * @param   $key    string    nom du param�tre
     * @return  mixed
     */
    public function &getParam( $key );
  }
?>