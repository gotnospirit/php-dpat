<?php
  /**
   * @package       XML
   * @class         xmlAbstractNode
   * @author        Jimmy CHARLEBOIS
   * @date          08-03-2007
   * @brief         
   */
  System::import( 'System.Interfaces.Xml.IXmlNode' );
  System::import( 'System.Xml.xmlEnumeration' );

  abstract class xmlAbstractNode implements IXmlNode {
    /**
     * @brief   Identifiant unique du noeud
     */
    private $_identifier;
    /**
     * @brief   Nom du noeud
     */
    private $_nodeName;
    /**
     * @brief   Collection des attributs du noeud
     */
    private $_attributes;
    /**
     * @brief   Collection des noeuds enfants
     */
    private $_children;
    /**
     * @brief   Noeud parent
     */
    private $_parent;
    /**
     * @brief   Type du noeud
     */
    private $_nodeType;

    protected function __construct( $type, $nodeName = null ) {
      $this->_identifier = uniqid( rand() );
      $this->_nodeName = $nodeName;
      $this->_attributes = array();
      $this->_children = array();
      $this->_parent = null;
      $this->_nodeType = $type;
    }

    public function &parentNode() {
      return $this->_parent;
    }

    public function getAttribute( $key ) {
      return ( array_key_exists( $key, $this->_attributes ) )
        ? $this->_attributes[ $key ]->nodeValue() : null;
    }

    public function &getAttributeNode( $key ) {
      $rv = null;
      if ( isset( $this->_attributes[ $key ] ) )
        $rv =& $this->_attributes[ $key ];
      return $rv;
    }

    public function setAttribute( $key, $value ) {
      System::import( 'System.Xml.xmlAttribute' );
      $this->_attributes[ strtolower( $key ) ] =& new xmlAttribute( $key, $value );
    }

    public function nodeType() {
      return $this->_nodeType;
    }

    public function nodeName( $value = null ) {
      if ( is_null( $value ) ) return $this->_nodeName;
      else $this->_nodeName = $value;
      return true;
    }

    public function nodeValue() {
      $rv = null;
      foreach( $this->_children AS $childIdentifier => $child )
        if ( $child->nodeType() == xmlEnumeration::TYPE_TEXT )
          $rv .= $child->nodeValue();
      return $rv;
    }


    public function hasParent() {
      return !is_null( $this->_parent );
    }

    public function hasAttribute( $key ) {
      return isset( $this->_attributes[ $key ] );
    }

    public function hasAttributes() {
      return count( $this->_attributes ) > 0;
    }

    public function &attributes() {
      return $this->_attributes;
    }

    public function removeAttribute( $key ) {
      if ( isset( $this->_attributes[ $key ] ) )
        unset( $this->_attributes[ $key ] );
    }

    public function appendChild( IXmlNode &$domNode ) {
      $this->_children[ $domNode->_identifier ] =& $domNode;
      $domNode->_parent =& $this;
    }

    public function removeChild( IXmlNode &$domNode ) {
      $askToChild = true;
      foreach( $this->_children AS $childId => $child )
        if ( $childId == $domNode->_identifier ) {
          unset( $this->_children );
          $askToChild = false;
        }
      if ( $askToChild )
        foreach( $this->_children AS $childId => $child )
          if ( $this->_children[ $childId ]->removeChild( $domNode ) )
            break;
      return !$askToChild;
    }

    public function hasChildNodes() {
      return count( $this->_children ) > 0;
    }

    public function &childNodes() {
      return $this->_children;
    }

    public function &firstChild() {
      $rv = null;
      foreach( $this->_children AS $childIdentifier => $child ) {
        $rv =& $this->_children[ $childIdentifier ];
        break;
      }
      return $rv;
    }

    public function &lastChild() {
      $rv = null;
      $max = count( $this->_children );
      $i = 0;
      foreach( $this->_children AS $childIdentifier => $child ) {
        if ( $i == $max - 1 ) {
          $rv =& $this->_children[ $childIdentifier ];
          break;
        }
        $i++;
      }
      return $rv;
    }

    public function &getElementById( $id ) {
      $rv = null;
      if ( $id == $this->getAttribute( 'id' ) )
        $rv =& $this;
      else
        foreach( $this->_children AS $childId => $child ) {
          if ( !is_null( $rv ) )
            break;
          if ( $id == $child->getAttribute( 'id' ) ) {
            $rv =& $this->_children[ $childId ];
            break;
          } else {
            $rv =& $child->getElementById( $id );
          }
        }
      return $rv;
    }

    public function getElementsByTagName( $nodeName ) {
      $rv = array();
      $nodeName = strtolower( $nodeName );
      foreach( $this->_children AS $childId => $child )
        if ( $nodeName == strtolower( $child->nodeName() ) )
          $rv[] =& $this->_children[ $childId ];
        else {
          $tmp = $this->_children[ $childId ]->getElementsByTagName( $nodeName );
          if ( count( $tmp ) > 0 )
            $rv = $rv + $tmp;
        }
      return $rv;
    }

    public function toString() {
      $hasTag = !is_null( $this->_nodeName );
      $rv = '';
      if ( $hasTag ) {
        $rv = '<'.$this->_nodeName;
        foreach( $this->_attributes AS $attributeIndex => $attribute )
          $rv .= ' '.$attribute->toString();
      }
      if ( !$this->hasChildNodes() ) {
        if ( $hasTag )
          $rv .= '/>'.System::crlf;
      } else {
        if ( $hasTag )
          $rv .= '>';
        foreach( $this->_children AS $childId => $child )
          $rv .= $child->toString();
        if ( $hasTag )
          $rv .= '</'.$this->_nodeName.'>'.System::crlf;
      }
      return $rv;
    }

    public function __toString() {
      return $this->toString();
    }

    /**
     * @brief   Normalise une chaîne suivant le standard xml
     * @param   $txt    string
     * @return  string
     */
    protected function encode( $txt ) {
      $from = array( '&', '"', '\'', '<', '>' );
      $to = array( '&amp;', '&quot;', '&apos;', '&lt;', '&gt;' );
      return str_replace( $from, $to, $txt );
    }

    /**
     * @brief   Normalise une chaîne suivant le standard xml
     * @param   $txt    string
     * @return  string
     */
    protected function decode( $txt ) {
      $from = array( '&amp;', '&quot;', '&apos;', '&lt;', '&gt;' );
      $to = array( '&', '"', '\'', '<', '>' );
      return str_replace( $from, $to, $txt );
    }
  }
?>