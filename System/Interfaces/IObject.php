<?php
  /**
   * @package     	Base
   * @interface     IObject
   * @author      	Jimmy CHARLEBOIS
   * @date        	14-04-2007
   */
  interface IObject {
    /**
     * @brief   Clone l'objet
     * @return  IObject
     */
    public function __clone();
  }
?>