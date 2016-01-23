<?php
  /**
   * @package     	Xml
   * @interface     IXmlDocument
   * @author      	Jimmy CHARLEBOIS
   * @date        	08-03-2007
   * @brief       	Interface DOM pour document xml
   */
  System::import( 'System.Interfaces.Xml.IXmlNode' );

  interface IXmlDocument extends IXmlNode {
    /**
     * @brief   Retourne la valeur de l'attribut encoding
     * @return  string
     */
    public function getEncoding();
    /**
     * @brief   D�finit la valeur de l'attribut encoding du document xml
     * @param   $value    string    la nouvelle valeur de cet attribut
     * @return  void
     */
    public function setEncoding( $value );

    /**
     * @brief   Retourne la valeur de l'attribut version
     * @return  string
     */
    public function getVersion();
    /**
     * @brief   D�finit la valeur de l'attribut version du document xml
     * @param   $value    string    la nouvelle valeur de cet attribut
     * @return  void
     */
    public function setVersion( $value );

    /**
     * @brief   Retourne la valeur de l'attribut standalone
     * @return  string
     */
    public function getStandalone();
    /**
     * @brief   D�finit la valeur de l'attribut standalone du document xml
     * @param   $value    string    la nouvelle valeur de cet attribut
     * @return  void
     */
    public function setStandalone( $value );

    /**
     * @brief   Retourne un objet xmlElement
     * @param   $nodeName   string    le nom du noeud � instancier
     * @return  xmlElement
     * @code
     *    $oDocument->createElement( 'body' );
     * @endcode
     */
    public function createElement( $nodeName );

    /**
     * @brief   Retourne un objet xmlTextNode
     * @param   $text   string    le texte contenu par le noeud
     * @return  xmlTextNode
     * @code
     *  $oDocument->createTextNode( 'Hello world!' );
     * @endcode
     */
    public function createTextNode( $text );

    /**
     * @brief   Retourne un objet xmlComment
     * @param   $text   string    le texte contenu par le noeud
     * @return  xmlComment
     * @code
     *  $oDocument->createComment( 'Mon petit commentaire' );
     * @endcode
     */
    public function createComment( $text );

    /**
     * @brief   Retourne un objet xmlCDataSection
     * @param   $text    string    le texte contenu par le noeud
     * @return  xmlCDataSection
     * @code
     *  $oDocument->createCDATASection( 'Mon pr�cieux texte pleins de caract�res a ne pas interpr�ter' );
     * @endcode
     */
    public function createCDATASection( $text );

    /**
     * @brief   Retourne le noeud racine du document xml
     * @return  IXmlNode
     */
    public function &getDocumentElement(); 

    /**
     * @brief   �crit le document xml dans un fichier
     * @param   $xmlFilepath    string    le nom du fichier dans lequel le document doit �tre �crit
     * @code
     *  if ( $oDocument->toFile( 'mon_fichier.xml' ) )
     *    echo 'Le fichier a �t� cr��';
     * @endcode
     * @deprecated
     */
    public function toFile( $xmlFilepath );

    /**
     * @brief   Charge un fichier xml
     * @param   $xmlFilepath    string    nom du fichier contenant le document xml
     * @return  xmlDocument|null
     * @code
     *  $oDocument = xmlDocument::loadFile( 'mon_fichier.xml' );
     * @endcode
     * @throw   FileNotFoundException
     */
    public static function &loadFile( $xmlFilepath );

    /**
     * @brief   Cr�e un objet xmlDocument � partir d'une cha�ne contenant le document xml
     * @param   $xmlString        string    cha�ne � partir de laquelle on va construire l'objet xmlDocument
     * @param   $separatorChar    string    s�parateur de ligne
     * @return  xmlDocument
     * @code
     *  $oDocument = xmlDocument::loadString(
     *    '<?xml version="1.0" encoding="iso-8859-1" ?>'."\n"
     *    . '<root><element>123</element></root>'
     *  );
     * @endcode
     * @throw   IllegalArgumentException
     */
    public static function &loadString( $xmlString, $separatorChar = System::crlf );
  }
?>