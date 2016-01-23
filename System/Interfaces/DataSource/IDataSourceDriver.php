<?php
  /**
   * @package     	DataSource
   * @interface     IDataSourceDriver
   * @author      	Jimmy CHARLEBOIS
   * @date        	20-11-2006
   * @brief       	Interface pour driver de source de données
   */
  interface IDataSourceDriver {
    /**
     * @brief   Retourne le protocole
     * @return  string
     */
    public function getScheme();

    /**
     * @brief   Retourne le domaine visé par le driver
     * @return  string
     */
    public function getDomain();

    /**
     * @brief   Retourne le paramètre
     * @return  string
     */
    public function getParameter();

    /**
     * @brief   Retourne la signature du driver
     */
    public function toString();
  }
?>