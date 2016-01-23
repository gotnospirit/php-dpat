<?php
  /**
   * @package     	Log
   * @interface     ILog
   * @author      	Jimmy CHARLEBOIS
   * @date        	23-01-2007
   * @brief       	Interface pour fichier de journalisation
   */

  interface ILog {
    /**
     * @brief   Ecrit une information dans le log
     * @param   $data           mixed     les données à enregistrer
     * @return  boolean
     * @throw   Exception
     */
    public function write( $data );

    /**
     * @brief   Efface les données du log
     * @throw   Exception
     */
    public function reset();
  }
?>