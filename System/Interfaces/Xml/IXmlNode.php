<?php
  /**
   * @package       Xml
   * @interface     IXmlNode
   * @author        Jimmy CHARLEBOIS
   * @date          08-03-2007
   * @brief         Interface DOM pour noeud xml
   */
  System::import( 'System.Interfaces.Xml.IXmlNode' );

  interface IXmlNode {
    /**
     * @brief   Retourne le noeud parent
     * @return  IXmlNode
     */
    public function &parentNode();

    /**
     * @brief   Retourne la valeur de l'attribut spécifié
     * @param   $key    string    le nom de l'attribut
     * @return  string
     */
    public function getAttribute( $key );

    /**
     * @brief   Retourne l'objet xmlAttribut correspondant au nom spécifié
     * @param   $key    string    le nom de l'attribut
     * @return  xmlAttribute
     */
    public function &getAttributeNode( $key );

    /**
     * @brief   Créé un nouvel objet attribut pour le noeud courant
     * @param   $key    string  le nom de l'attribut
     * @param   $value  string  la valeur de cet attribut
     * @return  void
     */
    public function setAttribute( $key, $value );

    /**
     * @brief   Retourne le type du noeud
     * @return  integer
     */
    public function nodeType();

    /**
     * @brief   Accesseur pour le nom du noeud
     * @param   $value    string  optional    le nom du noeud
     * @return  string
     */
    public function nodeName( $value = null );

    /**
     * @brief   Retourne la valeur du noeud courant ainsi que de tous ces noeuds de type Text enfants
     * @return  string
     */
    public function nodeValue();


    /*
     *  Méthodes publiques
     */
    /**
     * @brief   Indique si le noeud a un parent
     * @return  boolean
     */
    public function hasParent();

    /**
     * @brief   Indique si le noeud possède l'attribut spécifié
     * @param   $key    string    le noeud de l'attribut qu'on recherche
     * @return  boolean
     */
    public function hasAttribute( $key );

    /**
     * @brief   Indique si le noeud possède des attributs
     * @return  boolean
     */
    public function hasAttributes();

    /**
     * @brief  Retourne la collection des attributs du noeud
     * @return xmlAttribute[]
     */
    public function &attributes();

    /**
     * @brief   Supprime l'attribut dont le nom est spécifié
     * @param   $key    string    le nom de l'attribut à supprimer
     */
    public function removeAttribute( $key );

    /**
     * @brief   Ajoute un objet à la collection des noeuds enfants
     * @param   $domNode   IXmlNode    un objet de type xmlNode
     */
    public function appendChild( IXmlNode &$domNode );

    /**
     * @brief   Supprime l'objet spécifié de l'arborescence
     * @param   $domNode    IXmlNode    l'objet à supprimer
     * @return  boolean
     */
    public function removeChild( IXmlNode &$domNode );

    /**
     * @brief   Indique si le noeud possède des enfants
     * @return  boolean
     */
    public function hasChildNodes();

    /**
     * @brief   Retourne la collection des noeuds enfants
     * @return  IXmlNode[]
     */
    public function &childNodes();

    /**
     * @brief   Retourne le premier enfant
     * @return  IXmlNode
     */
    public function &firstChild();

    /**
     * @brief   Retourne le dernier enfant
     * @return  IXmlNode
     */
    public function &lastChild();

    /**
     * @brief   Retourne le noeud enfant ayant un attribut id correspondant
     * @param   $id   string    la valeur de l'attribut id du noeud recherché
     * @return  IXmlNode
     */
    public function &getElementById( $id );

    /**
     * @brief   Retourne une collection des noeuds portant le nom spécifié
     * @param   $nodeName   string    le nom du noeud recherché
     * @return  IXmlNode[]
     */
    public function getElementsByTagName( $nodeName );

    /**
     * @brief   Retourne le document xml en chaîne de caractères
     * @return  string
     */
    public function toString();
  }
?>