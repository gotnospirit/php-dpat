<?php
  /**
   * @package       Xml
   * @class         xmlTextNode
   * @author        Jimmy CHARLEBOIS
   * @date          08-03-2007
   * @brief         Classe représentant un noeud xml texte
   */
  System::import( 'System.Xml.xmlAbstractNode' );
  System::import( 'System.Xml.xmlEnumeration' );

  class xmlTextNode extends xmlAbstractNode {
    private $_value;

    public function __construct( $text ) {
      parent::__construct( xmlEnumeration::TYPE_TEXT );
      $this->_value = trim( $text );
    }

    public function nodeValue() {
      return $this->_value;
    }

    public function toString() {
      return $this->encode( $this->nodeValue() );
    }
  }
?>