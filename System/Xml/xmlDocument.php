<?php
  /**
   * @package       Xml
   * @class         xmlDocument
   * @author        Jimmy CHARLEBOIS
   * @date          08-03-2007
   * @brief         Classe représentant un document xml
   */
  System::import( 'System.Interfaces.Xml.IXmlNode' );
  System::import( 'System.Interfaces.Xml.IXmlDocument' );
  System::import( 'System.Xml.xmlAttribute' );
  System::import( 'System.Xml.xmlCDataSection' );
  System::import( 'System.Xml.xmlComment' );
  System::import( 'System.Xml.xmlElement' );
  System::import( 'System.Xml.xmlProcessingInstruction' );
  System::import( 'System.Xml.xmlTextNode' );
  System::import( 'System.Exceptions.IllegalArgumentException' );
  System::import( 'System.Exceptions.FileNotFoundException' );

  class xmlDocument implements IXmlNode, IXmlDocument {
    private $_encoding;
    private $_version;
    private $_standalone;

    private $_root;

    public function __construct( $nodeName = null ) {
      $this->_root =& new xmlElement( $nodeName );
      $this->_root->_parent =& $this;
      $this->_encoding = 'utf-8';
      $this->_version = '1.0';
      $this->_standalone = null;
    }

    public function &parentNode() {
      return $this->_root->parentNode();
    }

    public function getAttribute( $key ) {
      return $this->_root->getAttribute( $key );
    }

    public function &getAttributeNode( $key ) {
      return $this->_root->getAttributeNode( $key );
    }

    public function setAttribute( $key, $value ) {
      $this->_root->setAttribute( $key, $value );
    }

    public function nodeType() {
      return $this->_root->nodeType();
    }

    public function nodeName( $value = null ) {
      return $this->_root->nodeName();
    }

    public function nodeValue() {
      return $this->_root->nodeValue();
    }

    public function hasParent() {
      return $this->_root->hasParent();
    }

    public function hasAttribute( $key ) {
      return $this->_root->hasAttribute( $key );
    }

    public function hasAttributes() {
      return $this->_root->hasAttributes();
    }

    public function &attributes() {
      return $this->_root->attributes();
    }

    public function removeAttribute( $key ) {
      $this->_root->removeAttribute( $key );
    }

    public function appendChild( IXmlNode &$domNode ) {
      $this->_root->appendChild( $domNode );
    }

    public function removeChild( IXmlNode &$domNode ) {
      $this->_root->removeChild( $domNode );
    }

    public function hasChildNodes() {
      return $this->_root->hasChildNodes();
    }

    public function &childNodes() {
      return $this->_root->childNodes;
    }

    public function &firstChild() {
      return $this->_root->firstChild();
    }

    public function &lastChild() {
      return $this->_root->lastChild();
    }

    public function &getElementById( $id ) {
      return $this->_root->getElementById( $id );
    }

    public function getElementsByTagName( $nodeName ) {
      return $this->_root->getElementsByTagName( $nodeName );
    }

    public function getEncoding() {
      return $this->_encoding;
    }
    public function setEncoding( $value ) {
      $this->_encoding = $value;
    }

    public function getVersion() {
      return $this->_version;
    }
    public function setVersion( $value ) {
      $this->_version = $value;
    }

    public function getStandalone() {
      return $this->_standalone;
    }
    public function setStandalone( $value ) {
      $this->_standalone = $value;
    }

    public function createElement( $nodeName ) {
      return new xmlElement( $nodeName );
    }

    public function createTextNode( $text ) {
      return new xmlTextNode( $text );
    }

    public function createComment( $text ) {
      return new xmlComment( $text );
    }

    public function createCDATASection( $text ) {
      return new xmlCDataSection( $text );
    }

    public function &getDocumentElement() {
      $first =& $this->firstChild();
      if ( is_null( $first ) )
        return $this->_root;
      else
        return $first;
    }

    public function __toString() {
      return $this->toString();
    }

    public function toString() {
      $rv = '<?xml';
      if ( !is_null( $this->_version ) )
        $rv .= ' version="'.$this->_version.'"';
      if ( !is_null( $this->_encoding ) )
        $rv .= ' encoding="'.$this->_encoding.'"';
      if ( !is_null( $this->_standalone ) )
        $rv .= ' standalone="'.$this->_standalone.'"';
      $rv .= '?>'.System::crlf
        . $this->_root->toString();
      return $rv;
    }

    public function toFile( $xmlFilepath ) {
      $rv = false;
      if ( $fp = fopen( $xmlFilepath, 'w+' ) ) {
        fputs( $fp, (string)$this );
        fclose( $fp );
        $rv = true;
      }
      return $rv;
    }

    public static function &loadFile( $xmlFilepath ) {
      if ( !file_exists( $xmlFilepath ) )
        throw new FileNotFoundException( $xmlFilepath );
      else {
        $rv = null;
        $tmpContent = '';
        if ( $fp = fopen( $xmlFilepath, 'r' ) ) {
          while( !feof( $fp ) )
            $tmpContent .= fgets( $fp, 4096 );
          fclose( $fp );
        }
        if ( '' != $tmpContent )
          $rv =& xmlDocument::loadString( trim( $tmpContent ) );
        return $rv;
      }
    }

    public static function &loadString( $xmlString, $separatorChar = System::crlf ) {
      $rv = null;
      $lines = explode( $separatorChar, $xmlString );
      if ( count( $lines ) == 0 )
        throw new IllegalArgumentException( 'données xml non valides' );
      else {
        $declaration = trim( array_shift( $lines ) );

        $matches = array();
        preg_match( '/<\?xml(.*?)\?>$/', $declaration, $matches );
//        preg_match( '/^<\?xml(.*?)\?'.'>$/', $declaration, $matches );
//      supprimé à cause du BOM des fichiers UTF8
        if ( 0 == count( $matches ) )
          throw new IllegalArgumentException( 'La déclaration xml est manquante ou incorrecte' );
        else {
          $rv = new xmlDocument();
          // analyse de la déclaration xml
          preg_match_all( '/([a-z0-9_-]+)="(.+)"/U', $matches[ 1 ], $matches );
          if ( count( $matches ) > 0 ) {
            $n_attributes = count( $matches[ 0 ] );
            for( $i=0; $i<$n_attributes; $i++ )
              switch( strtolower( $matches[ 1 ][ $i ] ) ) {
                case 'encoding':
                  $rv->setEncoding( $matches[ 2 ][ $i ] );
                  break;
                case 'version':
                  $rv->setVersion( $matches[ 2 ][ $i ] );
                  break;
                case 'standalone':
                  $rv->setStandalone( $matches[ 2 ][ $i ] );
                  break;
              }
          }

          // analyse des noeuds
          $tmp = implode( System::crlf, $lines );
          preg_match_all( '/<([^>\s]*?)([^>]*?)>([^<]*?)/Uims', $tmp, $matches );
          if ( count( $matches ) > 0 ) {
            $specialNodeFirstChar = array( '!', '?' );
            $n_entity = count( $matches[ 0 ] );
            $parentNode =& $rv;
            $newNode = null;
            $lastNodenodeName = $lastNodeHasChild = null;
            for( $i=0; $i<$n_entity; $i++ ) {
              $isCloseTag = ( '/' == $matches[ 1 ][ $i ]{ 0 } );
              $isSpecialNode = ( !$isCloseTag && in_array( $matches[ 1 ][ $i ]{ 0 }, $specialNodeFirstChar ) );
              $nodeName = ( $isCloseTag )
                ? substr( $matches[ 1 ][ $i ], 1 ) : $matches[ 1 ][ $i ];
              if ( '/' == substr( $nodeName, -1 ) )
                $nodeName = substr( $nodeName, 0, -1 );
              $hasChild = ( !$isSpecialNode && !$isCloseTag && '/' != substr( trim( $matches[ 2 ][ $i ] ), -1 ) );

              $text = trim( $matches[ 3 ][ $i ] );

              if ( $isCloseTag ) {
                $parentNode =& $newNode->parentNode();
                if ( strlen( $text ) > 0 ) {
                  $tmp =& $parentNode->parentNode();
                  $tmp->appendChild( new xmlTextNode( $text ) );
                }
                $newNode =& $parentNode;
              } else {
                if ( !is_null( $newNode ) )
                  if ( $lastNodenodeName == $nodeName ) $parentNode =& $newNode->parentNode();
                  else {
                    if ( $lastNodeHasChild ) $parentNode =& $newNode;
                    else $parentNode =& $newNode->parentNode();
                  }

                if ( $isSpecialNode ) {
                  $specialType = substr( $nodeName, 0, 1 );
                  $nodeName = substr( $nodeName, 1 );
                  if ( '!' == $specialType ) {
                    $value = substr( rtrim( $matches[ 0 ][ $i ] ), 2, -1 );
                    $isCData = ( '[CDATA[' == substr( $value, 0, 7 ) );
                    if ( $isCData ) {
                      $nodeName = '[CDATA[';
                      $newNode =& new xmlCDataSection( substr( $value, strlen( $nodeName ), -2 ) );
                    } else {
                      $nodeName = '--';
                      $newNode =& new xmlComment( substr( $value, strlen( $nodeName ), -2 ) );
                    }
                  } elseif ( '?' == $specialType ) {
                    $newNode =& new xmlProcessingInstruction();
                  } else trigger_error( 'Type inconnu', E_USER_WARNING );
                } else $newNode =& new xmlElement( $nodeName );
                $newNode->nodeName( $nodeName );

                $attributes = array();
                preg_match_all( '/([a-z0-9_:-]+)="(.+)"/U', $matches[ 2 ][ $i ], $attributes );
                if ( count( $attributes ) > 0 && count( $attributes[ 0 ] ) > 0 )
                  foreach( $attributes[ 1 ] AS $idx => $key )
                    $newNode->setAttribute( $key, $attributes[ 2 ][ $idx ] );

                if ( !is_null( $parentNode ) )
                  $parentNode->appendChild( $newNode );

                $lastNodenodeName = $nodeName;
                $lastNodeHasChild = $hasChild;

                if ( strlen( $text ) > 0 )
                  if ( $hasChild ) $newNode->appendChild( new xmlTextNode( $text ) );
                  else $parentNode->appendChild( new xmlTextNode( $text ) );
              }
            }
          }
        }
      }
      return $rv;
    }
  }
?>