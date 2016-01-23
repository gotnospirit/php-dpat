<?php
  /**
   * @package     	IO
   * @interface     IStream
   * @author      	Jimmy CHARLEBOIS
   * @date        	24-04-2007
   * @brief       	
   */

  interface IStream {
    /**
     * @brief   Lit les donn�es publi�es sur le socket du client
     * @return  boolean
     */
    public function read();

    /**
     * @brief   Ecrit des donn�es sur le socket du client
     * @return  integer
     */
    public function write( $data );
  }
?>