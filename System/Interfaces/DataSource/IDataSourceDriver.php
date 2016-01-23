<?php
  /**
   * @package     	DataSource
   * @interface     IDataSourceDriver
   * @author      	Jimmy CHARLEBOIS
   * @date        	20-11-2006
   * @brief       	Interface pour driver de source de donn�es
   */
  interface IDataSourceDriver {
    /**
     * @brief   Retourne le protocole
     * @return  string
     */
    public function getScheme();

    /**
     * @brief   Retourne le domaine vis� par le driver
     * @return  string
     */
    public function getDomain();

    /**
     * @brief   Retourne le param�tre
     * @return  string
     */
    public function getParameter();

    /**
     * @brief   Retourne la signature du driver
     */
    public function toString();
  }
?>