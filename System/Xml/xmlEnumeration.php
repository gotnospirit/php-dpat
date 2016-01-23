<?php
  /**
   * @package       Xml
   * @class         xmlEnumeration
   * @author        Jimmy CHARLEBOIS
   * @date          08-03-2007
   * @brief         Enumération pour Xml
   */

  final class xmlEnumeration {
    /**
     * @defgroup  XmlNodeType    Constantes pour les types d'éléments xml
     */
    /*@{*/
    const TYPE_ELEMENT          = 1;
    const TYPE_ATTRIBUTE        = 2;
    const TYPE_TEXT             = 3;
    const TYPE_CDATASECTION     = 4;
    const TYPE_ENTITYREFERENCE  = 5;
    const TYPE_ENTITY           = 6;
    const TYPE_PROCESSING       = 7;
    const TYPE_COMMENT          = 8;
    const TYPE_DOCUMENT         = 9;
    const TYPE_DOCUMENTTYPE     = 10;
    const TYPE_DOCUMENTFRAGMENT = 11;
    const TYPE_NOTATION         = 12;
    /*@}*/

    private function __construct()
    {}
  }
?>