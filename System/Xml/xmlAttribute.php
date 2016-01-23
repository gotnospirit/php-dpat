<?php
  /**
   * @package       Xml
   * @class         xmlAttribute
   * @author        Jimmy CHARLEBOIS
   * @date          08-03-2007
   * @brief         Classe représentant un attribut d'un noeud xml
   */
  System::import( 'System.Xml.xmlAbstractNode' );
  System::import( 'System.Xml.xmlEnumeration' );

  class xmlAttribute extends xmlAbstractNode {
    private $_value;

    public function __construct( $key, $value ) {
      parent::__construct( xmlEnumeration::TYPE_ATTRIBUTE, $key );
      $this->_value = $value;
    }

    public function nodeValue() {
      return $this->_value;
    }

    public function toString() {
      $rv = sprintf(
        '%s="%s"',
        $this->nodeName(),
        $this->encode( $this->nodeValue() )
      );
      return $rv;
    }
  }
?>