<?php
  /**
   * @package       Xml
   * @class         xmlElement
   * @author        Jimmy CHARLEBOIS
   * @date          08-03-2007
   * @brief         Classe repr�sentant une section cdata xml
   */
  System::import( 'System.Xml.xmlAbstractNode' );
  System::import( 'System.Xml.xmlEnumeration' );

  class xmlElement extends xmlAbstractNode {
    public function __construct( $nodeName ) {
      parent::__construct( xmlEnumeration::TYPE_ELEMENT, $nodeName );
    }
  }
?>