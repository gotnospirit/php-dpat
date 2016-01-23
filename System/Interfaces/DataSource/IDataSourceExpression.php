<?php
  /**
   * @package     	DataSource
   * @interface     IDataSourceExpression
   * @author      	Jimmy CHARLEBOIS
   * @date        	21-11-2006
   * @brief       	Interface pour expression visant un DataSource
   */

  interface IDataSourceExpression {
    /**
     * @brief   Retourne une version textuelle de l'expression
     * @return  string
     */
    public function toString();
  }
?>