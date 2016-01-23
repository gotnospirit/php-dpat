<?php
  /**
   * @package       Xml
   * @class         xmlCDataSection
   * @author        Jimmy CHARLEBOIS
   * @date          08-03-2007
   * @brief         Classe représentant une section cdata xml
   */
  System::import( 'System.Xml.xmlAbstractNode' );
  System::import( 'System.Xml.xmlEnumeration' );
  System::import( 'System.Xml.xmlTextNode' );

  class xmlCDataSection extends xmlAbstractNode {
    private $_value;

    public function __construct( $text ) {
      parent::__construct( xmlEnumeration::TYPE_CDATASECTION );
      $this->appendChild( new xmlTextNode( $text ) );
    }

    public function toString() {
      $children = $this->childNodes();
      $rv = '<!'.$this->nodeName();
      foreach( $children AS $childId => $child )
        $rv .= $child->toString();
      $rv .= ']]>';
      return $rv;
    }
  }
?>