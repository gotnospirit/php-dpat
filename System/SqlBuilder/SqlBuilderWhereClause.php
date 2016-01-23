<?php
  /**
   * @package     	Sql
   * @class       	SqlBuilderWhereClause
   * @author      	Jimmy CHARLEBOIS
   * @date        	22-11-2206
   * @brief       	Implémentation pour clauses de requêtes SQL
   */

  class SqlBuilderWhereClause {
    public $operator;
    public $sign;
    public $alias;
    public $value;
    public $value_type;

    private $_ItsKey;
    private $_ItsChildren;
    private $_ItsParent;

    public function __construct( $key = null ) {
      $this->operator = null;
      $this->sign = null;
      $this->alias = null;
      $this->value = null;
      $this->value_type = null;

      $this->_ItsKey = $key;
      $this->_ItsChildren = array();
      $this->_ItsParent = null;
    }

    /**
     * @brief   Définit la clé du groupe
     * @param   $key    mixed
     * @return  void
     */
    protected function setKey( $key ) { $this->_ItsKey = $key; }

    /**
     * @brief   Retourne la clé du groupe
     * @return  mixed
     * @see     getPath
     */
    public function getKey() { return $this->_ItsKey; }

    /**
     * @brief   Retourne le path du noeud
     * @return  string
     * @see     find
     */
    public function getPath() {
      $rv = null;
      if ( !is_null( $this->_ItsParent ) && !is_null( $this->_ItsParent->getPath() ) )
        $rv .= $this->_ItsParent->getPath().'-';
      if ( !is_null( $this->_ItsKey ) )
        $rv .= $this->_ItsKey;
      return $rv;
    }

    /**
     * @internal
     * @brief   Définit le noeud parent du groupe
     * @param   $clause   SqlBuilderWhereClause   le noeud parent
     * @return  void
     */
    protected function setParent( SqlBuilderWhereClause &$clause ) { $this->_ItsParent =& $clause; }

    /**
     * @brief   Retourne le noeud parent du groupe
     * @return  SqlBuilderWhereClause
     */
    public function &getParent() { return $this->_ItsParent; }

    /**
     * @brief   Indique si le groupe a des clauses enfants
     * @return  boolean
     */
    public function hasChildren() { return count( $this->_ItsChildren ) > 0; }

    /**
     * @brief   Retourne une collection des enfants du groupe
     * @return  array
     */
    public function &getChildren() { return $this->_ItsChildren; }

    /**
     * @brief   Ajoute une clause
     * @param   $clause
     */
    public function addChild( SqlBuilderWhereClause &$clause ) {
      $clauseKey = count( $this->_ItsChildren );
      $clause->setKey( $clauseKey );
      $clause->setParent( $this );
      $this->_ItsChildren[ $clauseKey ] =& $clause;
      return $clause->getPath();
    }

    /**
     * @brief   Trouve le noeud parent dans l'arborescence du groupe
     * @param   $path   string    chemin du noeud
     * @return  SqlBuilderWhereClause
     */
    public function &find( $path ) {
      $rv = null;
      if ( strpos( $path, '-' ) !== false ) {
        $childKey = substr( $path, 0, strpos( $path, '-' ) );
        if ( isset( $this->_ItsChildren[ $childKey ] ) )
          $rv =& $this->_ItsChildren[ $childKey ]->find( substr( $path, strpos( $path, '-' ) + 1 ) );
      } else {
        foreach( $this->_ItsChildren AS $childKey => &$oChild )
          if ( $path == $oChild->getKey() ) {
            $rv =& $oChild;
            break;
          } else
            $rv =& $oChild->find( $path );
      }
      return $rv;
    }
  }
?>