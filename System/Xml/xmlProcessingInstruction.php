<?php
  /**
   * @package     	Xml
   * @class       	xmlProcessingInstruction
   * @author      	Jimmy CHARLEBOIS
   * @date        	08-03-2007
   * @brief       	Classe représentant une instruction xml
   */
  System::import( 'System.Xml.xmlAbstractNode' );
  System::import( 'System.Xml.xmlEnumeration' );

  class xmlProcessingInstruction extends xmlAbstractNode {
    public function __construct() {
      parent::__construct( xmlEnumeration::TYPE_PROCESSING );
    }

    public function toString() {
      $attrs = $this->attributes();
      $rv = '<?'.$this->nodeName();
      foreach( $attrs AS $attributeIndex => $attribute )
        $rv .= ' '.$attribute->toString();
      $rv .= '?>';
      return $rv;
    }
  }
?>