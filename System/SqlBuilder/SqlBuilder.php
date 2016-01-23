<?php
  /**
   * @package     	SqlBuilder
   * @class       	SqlBuilder
   * @author      	Jimmy CHARLEBOIS
   * @date        	22-11-2006
   * @brief       	Classe permettant de construire dynamiquement une requête SQL
   */
  System::import( 'System.SqlBuilder.SqlBuilderWhereClause' );
  System::import( 'System.SqlBuilder.sqlBuilderField' );
  System::import( 'System.SqlBuilder.sqlBuilderFunction' );

  class SqlBuilder {
    private $_ItsTables;
    private $_ItsFields;
    public $_ItsWhere;
    private $_ItsJoins;
    private $_ItsJoinsWhere;
    private $_clauses;
    private $_updateInsertFields;

    const AliasPrefix = 'SB_';

    /**
     * @defgroup    SqlOperators   Constantes pour les opérateurs
     */
    /*@{*/
    const AndOperator = 'AND';
    const OrOperator = 'OR';
    /*@}*/

    /**
     * @defgroup    JoinTypes   Constantes pour les types de jointures
     */
    /*@{*/
    const InnerJoin = 'INNER JOIN';
    const LeftOuter = 'LEFT OUTER JOIN';
    const RightOuter = 'RIGHT OUTER JOIN';
    /*@}*/

    /**
     * @defgroup    OrderTypes   Constantes pour les types d'ordonnancements
     */
    /*@{*/
    const OrderAscending = 'ASC';
    const OrderDescending = 'DESC';
    /*@}*/

    /**
     * @defgroup    WhereTypes   Constantes pour les types de clauses where
     */
    /*@{*/
/*
    const TypeField = 1;
    const TypeFunction = 2;
*/
    /*@}*/

    /**
     * @defgroup    ClauseTypes   Constantes pour les types de clauses
     */
    /*@{*/
    const ClauseGroupBy = 'GROUP BY';
    const ClauseOrderBy = 'ORDER BY';
    const ClauseHaving = 'HAVING';
    /*@}*/

    /**
     * @defgroup    FieldTypes    Constantes pour les types de données
     */
    /*@{*/
    const SqlTypeString     = 1;
    const SqlTypeNumeric    = 2;
    const SqlTypeDate       = 4;
    const SqlTypeFunction   = 99;
    /*@}*/

    public function __construct() {
      $this->reset();
    }

    /**
     * @brief   Initialise le constructeur de requêtes
     * @return  void 
     */
    public function reset() {
      $this->_ItsTables = array();
      $this->_ItsFields = array();
      $this->_ItsJoins = array();
      $this->_ItsJoinsWhere = array();
      $this->_ItsWhere = array();
      $this->_clauses = array();
      $this->_updateInsertFields = array();
    }

    /**
     * @brief   Alias une table en générant un identifiant unique s'il n'est pas précisé
     * @param   $tableName    string    le nom de la table à aliaser
     * @param   $alias        string    un alias si l'on souhaite le forcer
     * @return  string    l'alias créé pour la table
     * @code
     *    $oSql =& new SqlBuilder();
     * 
     *    // sans forcer l'alias
     *    $alias = $oSql->aliasTable( 'ma_table' ); // $alias faudra quelque chose comme SB_456456e85e992
     * 
     *    // en forçant l'alias
     *    $alias = $oSql->aliasTable( 'ma_table', 'A' ); // $alias faudra A 
     * @endcode
     */
    public function aliasTable( $tableName, $alias = null ) {
      if ( is_null( $alias ) ) {
        while( 1 ) {
          $tmp = uniqid( self::AliasPrefix );
          if ( !array_key_exists( $tmp, $this->_ItsTables ) ) {
            $alias = $tmp;
            break;
          }
        }
      }
      $this->_ItsTables[ $alias ] = $tableName;
      return $alias;
    }

    /**
     * @brief   Retourne le nom d'une table d'après son alias
     * @param   $tableAlias   string    un alias de table
     * @return  string|null
     */
    private function _getTableName( $tableAlias ) {
      $rv = null;
      if ( array_key_exists( $tableAlias, $this->_ItsTables ) )
        $rv = $this->_ItsTables[ $tableAlias ];
      return $rv;
    }

    /**
     * @brief    Ajoute un champ à la collection de ceux à récupérer lors d'un select
     * @param    $tableAlias    string    l'alias de la table dont fait parti le champ
     * @param    $fieldName     string    le nom du champ que l'on souhaite sélectionner
     * @param    $fieldAlias    string    un alias pour ce champ
     * @return   void
     * @throw    Exception
     */
    public function get( $tableAlias, $fieldName, $fieldAlias = null ) {
      if ( !array_key_exists( $tableAlias, $this->_ItsTables ) )
        throw new Exception( 'Alias de table non enregistré : '.$tableAlias );
      if ( !array_key_exists( $tableAlias, $this->_ItsFields ) )
        $this->_ItsFields[ $tableAlias ] = array();
      $this->_ItsFields[ $tableAlias ][ $fieldName ] = new sqlBuilderField( $tableAlias, $fieldName, $fieldAlias );
    }

    /**
     * @brief    Ajoute un appel de fonction sql à la collection de champs à récupérer lors d'un select
     * @param    $tableAlias    string    l'alias de la table dont fait parti le champ
     * @param    $expression    string    l'appel de la fonction sql
     * @param    $fieldAlias    string    un alias pour ce champ
     * @return   void
     * @throw    Exception
     */
    public function getFunction( $tableAlias, $expression, $fieldAlias ) {
      if ( !array_key_exists( $tableAlias, $this->_ItsTables ) )
        throw new Exception( 'Alias de table non enregistré : '.$tableAlias );
      if ( !array_key_exists( $tableAlias, $this->_ItsFields ) )
        $this->_ItsFields[ $tableAlias ] = array();
      $this->_ItsFields[ $tableAlias ][ $expression ] = new sqlBuilderFunction( $expression, $fieldAlias );
    }

    /**
     * @brief   Associe une valeur à un champ pour une requête update / insert
     * @param   $fieldName   string    nom du champ
     * @param   $value       string    valeur du champ
     * @param   $sqlType     integer   optional type de donnée \ref FieldTypes
     * @return  void
     * @code
     *   $oSql->Set( 'mon_champ', 123, SysSqlTypeNumeric );
     * @endcode
     */
    public function set( $fieldName, $value, $sqlType = self::SqlTypeString ) {
      $this->_updateInsertFields[ $fieldName ] = array(
        'value' => $value,
        'type' => $sqlType
      );
    }

    /**
     * @brief   Ajoute une clause group by à la requête à générer
     * @return  void
     */
    public function groupBy() {
      $args = func_get_args();
      array_unshift( $args, self::ClauseGroupBy );
      call_user_func_array( array( $this, 'clause' ), array( 'items' => $args, 'operator' => ', ' ) );
    }

    /**
     * @brief   Ajoute une clause order by à la requête à générer
     * @return  void
     */
    public function orderBy() {
      $args = func_get_args();
      $count = count( $args );
      if ( $count == 1 )
        $dir = self::OrderAscending;
      elseif ( $count == 2 ) {
        if ( '' != $this->_getTableName( $args[ 0 ] ) )
          $dir = self::OrderAscending;
        else {
          $dir = array_pop( $args );
          $count--;
        }
      } else {
        $dir = array_pop( $args );
        $count--;
      }
      $args[ $count - 1 ] .= ' '.$dir;
      array_unshift( $args, self::ClauseOrderBy );
      call_user_func_array( array( $this, 'clause' ), array( 'items' => $args, 'operator' => ', ' ) );
    }

    /**
     * @brief   Ajoute une clause having à la requête à générer
     * @return  void
     */
    public function having( $expression, $operator = sqlBuilder::AndOperator ) {
      $args = array( self::ClauseHaving, $expression );
      call_user_func_array( array( $this, 'clause' ), array( 'items' => $args, 'operator' => ' '.$operator.' ' ) );
    }

    /**
     * @internal
     * @brief   Ajoute une clause à la requête à générer
     * @see     having, orderBy, groupBy
     */
    protected function clause() {
      $arguments = func_get_args();
      $type = $arguments[ 0 ][ 0 ];
      if ( count( $arguments[ 0 ] ) >= 3 ) {
        $value = array(
          'table' => $arguments[ 0 ][ 1 ],
          'field' => $arguments[ 0 ][ 2 ]
        );
      } else {
        $value = $arguments[ 0 ][ 1 ];
      }
      $operator = ( isset( $arguments[ 1 ] ) )
        ? $arguments[ 1 ] : null;
      if ( !isset( $this->_clauses[ $type ] ) )
        $this->_clauses[ $type ] = array();
      $this->_clauses[ $type ][] = array(
        'value' => $value,
        'operator' => $operator
      );
    }

    /**
     * @internal
     * @brief   Structure une jointure
     * @param   $leftTableAlias     string    l'alias de la table de gauche
     * @param   $leftJoinField      string    le champ de la table de gauche qui sert à la jointure
     * @param   $rightTableAlias    string    l'alias de la table de droite
     * @param   $rightJoinField     string    le champ de la table de droite qui sert à la jointure
     * @param   $joinFieldSign      string    opération entre les champs
     * @param   $joinOperator       const     type de la jointure
     * @return  string    clé de la jointure qui permettra d'ajouter des contraintes supplémentaires sur celle-ci
     */
    protected function join( $leftTableAlias, $leftJoinField, $rightTableAlias, $rightJoinField, $joinFieldSign, $joinOperator ) {
      $joinKey = md5( $leftTableAlias.$leftJoinField.$rightTableAlias.$rightJoinField.$joinFieldSign.$joinOperator );
      if ( !array_key_exists( $joinKey, $this->_ItsJoins ) )
        $this->_ItsJoins[ $joinKey ] = array();
      if ( !array_key_exists( $leftTableAlias, $this->_ItsJoins[ $joinKey ] ) )
        $this->_ItsJoins[ $joinKey ][ $leftTableAlias ] = array();
      if ( !array_key_exists( $joinOperator, $this->_ItsJoins[ $joinKey ][ $leftTableAlias ] ) )
        $this->_ItsJoins[ $joinKey ][ $leftTableAlias ][ $joinOperator ] = array();
      $this->_ItsJoins[ $joinKey ][ $leftTableAlias ][ $joinOperator ][] = array(
        $rightTableAlias => array(
          0 => $leftJoinField,
          1 => $joinFieldSign,
          2 => $rightJoinField
        )
      );
      return $joinKey;
    }

    /**
     * @brief   Créer une jointure entre tables pour la requête à générer
     * @param   $leftTableAlias     string    l'alias de la table de gauche
     * @param   $leftJoinField      string    le champ de la table de gauche qui sert à la jointure
     * @param   $rightTableAlias    string    l'alias de la table de droite
     * @param   $rightJoinField     string    le champ de la table de droite qui sert à la jointure
     * @param   $joinFieldSign      string    opération entre les champs
     * @param   $joinType           const     type de jointure (Left, Right, Inner, Outer) \see JoinTypes
     */
    public function joinTable( $leftTableAlias, $leftJoinField, $rightTableAlias, $rightJoinField, $joinFieldSign = '=', $joinType = self::InnerJoin ) {
      return $this->join( $leftTableAlias, $leftJoinField, $rightTableAlias, $rightJoinField, $joinFieldSign, $joinType );
    }

    /**
     * @brief   Ajoute une clause where sur un champ à la requête à générer
     * @param   $tableAlias       string    alias de la table visée
     * @param   $fieldAlias       string    alias du champ visé
     * @param   $fieldValue       mixed     valeur du champ pour cette clause
     * @param   $whereOperation   string    opérand
     * @param   $whereOperator    const     opérateur pour la clause  \see  SqlOperators
     * @param   $valueType        const     type de la valeur \see  FieldTypes
     * @param   $whereJoinKey     string    clé de la jointure sur laquelle on applique la clause
     * @param   $parentKey        string    clé d'une clause parente
     * @return  string    clé de la clause générée
     */
    public function whereField( $tableAlias, $fieldAlias, $fieldValue, $whereOperation, $whereOperator, $valueType = self::SqlTypeString, $whereJoinKey = null, $parentKey = null ) {
      return self::where( $tableAlias, $fieldAlias, $fieldValue, $whereOperation, $whereOperator, $whereJoinKey, $valueType, $parentKey );
    }

    /**
     * @note    Idem que whereField mais destinée à être appliquée sur un alias de fonction
     */
    public function whereFunction( $tableAlias, $fieldAlias, $fieldValue, $whereOperation, $whereOperator, $whereJoinKey = null, $parentKey = null ) {
      return self::where( $tableAlias, $fieldAlias, $fieldValue, $whereOperation, $whereOperator, $whereJoinKey, self::SqlTypeFunction, $parentKey );
    }

    /**
     * @internal
     * @brief   Dispatche la demande de génération d'une clause where de "jointure ou de valeur"
     * @param   $tableAlias       string    alias de la table visée
     * @param   $fieldAlias       string    alias du champ visé
     * @param   $fieldValue       mixed     valeur du champ pour cette clause
     * @param   $whereOperation   string    opérand
     * @param   $whereOperator    const     opérateur pour la clause  \see  SqlOperators
     * @param   $whereJoinKey     string    clé de la jointure sur laquelle on applique la clause
     * @param   $whereValueType   const     type de la valeur \see  FieldTypes
     * @param   $parentKey        string    clé d'une clause parente
     * @return  string    clé de la clause générée
     */
    protected function where( $tableAlias, $fieldAlias, $fieldValue, $whereOperation, $whereOperator, $whereJoinKey = null, $whereValueType = self::SqlTypeString, $parentKey = null ) {
      if ( !is_null( $whereJoinKey ) ) {
        return $this->whereJoin( $whereJoinKey, $tableAlias, $fieldAlias, $fieldValue, $whereOperation, $whereValueType, $whereOperator, $parentKey );
      } else {
        return $this->whereTable( $tableAlias, $fieldAlias, $fieldValue, $whereOperation, $whereValueType, $whereOperator, $parentKey );
      }
    }

    /**
     * @internal
     * @brief   Génère une clause de valeur pour un alias de table
     */
    protected function whereTable( $tableAlias, $fieldAlias, $fieldValue, $whereOperation, $whereValueType, $operator, $parentKey = null ) {
      if ( !array_key_exists( $tableAlias, $this->_ItsWhere ) )
        $this->_ItsWhere[ $tableAlias ] =& new SqlBuilderWhereClause();
      $base =& $this->_ItsWhere[ $tableAlias ];

      $tmp =& new SqlBuilderWhereClause( $parentKey );
      $tmp->operator = $operator;
      $tmp->sign = $whereOperation;
      $tmp->alias = $fieldAlias;
      $tmp->value = $fieldValue;
      $tmp->value_type = $whereValueType;

      if ( !is_null( $parentKey ) ) {
        $tmpBase =& $base->find( $parentKey );
        if ( !is_null( $tmpBase ) )
          $base =& $tmpBase;
      }

      return $base->addChild( $tmp );
    }

    /**
     * @internal
     * @brief   Génère une clause sur une jointure
     */
    protected function whereJoin( $joinKey, $tableAlias, $fieldAlias, $fieldValue, $whereOperation, $whereValueType, $operator, $parentKey = null ) {
      if ( !array_key_exists( $joinKey, $this->_ItsJoinsWhere ) )
        $this->_ItsJoinsWhere[ $joinKey ] = array();
      if ( !array_key_exists( $tableAlias, $this->_ItsJoinsWhere[ $joinKey ] ) )
        $this->_ItsJoinsWhere[ $joinKey ][ $tableAlias ] =& new sqlBuilderWhereClause();
      $base =& $this->_ItsJoinsWhere[ $joinKey ][ $tableAlias ];

      $tmp =& new SqlBuilderWhereClause( $parentKey );
      $tmp->operator = $operator;
      $tmp->sign = $whereOperation;
      $tmp->alias = $fieldAlias;
      $tmp->value = $fieldValue;
      $tmp->value_type = $whereValueType;

      if ( !is_null( $parentKey ) ) {
        $tmpBase =& $base->find( $parentKey );
        if ( !is_null( $tmpBase ) )
          $base =& $tmpBase;
      }

      return $base->addChild( $tmp );
    }

    /**
     * @internal
     * @brief   Normalise une valeur pour la requête à générer
     * @param   $value    mixed   la valeur à normaliser
     * @param   $type     const   type de la donnée
     * @return  string
     * @note    si la valeur est nulle insère NULL ou double les quotes dans le cas contraire si nécessaire
     */
    protected static function normalizeValue( $value, $type = null ) {
      if ( is_null( $value ) )
        $value = 'NULL';
      if ( is_null( $type ) )
        $type = self::SqlTypeString;
      switch( $type ) {
        case self::SqlTypeNumeric:
        case self::SqlTypeFunction:
          break;
        case self::SqlTypeString:
        case self::SqlTypeDate:
          if ( 'NULL' != $value )
            $value = '\''.str_replace( '\'', '\'\'', $value ).'\'';
          break;
      }
      return $value;
    }

    /**
    * @brief    Fournit une collection dans tables "gauches" (base de la jointure)
    * @return   array
    */
    protected function getLeftTables() {
      $rv = $this->_ItsTables;
      // On retire toutes les tables qui sont cible d'une jointure (table droite)
      foreach( $this->_ItsJoins AS $joinKey => $joinStruct )
        foreach( $joinStruct AS $tableAlias => $leftTables )
          foreach( $leftTables AS $joinOperator => $joinElements )
            foreach( $joinElements AS $idx => $elements )
              foreach( $elements AS $rightTableAlias => $fields ) {
                if ( array_key_exists( $rightTableAlias, $rv ) )
                  unset( $rv[ $rightTableAlias ] );
              }
      return $rv;
    }

    /**
     * @internal
     * @brief   Construit les clauses d'un groupe (table ou jointure)
     * @param   $tableAlias             string                  alias de la table de gauche
     * @param   $clause                 SqlBuilderWhereClause   groupe de clauses associées
     * @param   $appendFirstOperator    boolean                 indique si l'on doit préfixer avec l'opérateur du 1er groupe de clause
     * @param   $index                  integer                 permet lors de la récursion de savoir si on peut insérer l'opérateur du 1er groupe de clause
     * @return  string
     */
    protected static function computeWhereGroup( $tableAlias, $clause, $appendFirstOperator = false, $index = 0 ) {
      $rv = '';
      $clauses = $clause->getChildren();
      $countClauses = count( $clauses );
      if ( 0 == $countClauses )
        return $rv;
      $i = 0;
      foreach( $clauses AS $clauseKey => &$oClause ) {
        if ( is_array( $oClause->value ) )
          $clauseValue = array_map( array( 'self', 'normalizeValue' ), $oClause->value );
        else
          $clauseValue = self::normalizeValue( $oClause->value, $oClause->value_type );
/*
        if ( self::TypeFunction == $oClause->value_type ) {
          $clauseValue = $oClause->value;
        } elseif ( self::TypeField == $oClause->value_type ) {
          $clauseValue = ( is_numeric( $oClause->value ) )
            ? $oClause->value
            : self::normalizeValue( $oClause->value, self::SqlTypeString );
        }
*/
        if ( $appendFirstOperator || $i > 0 )
          $rv .= $oClause->operator.' ';
        $hasChildren = $oClause->hasChildren();
        if ( $hasChildren )
          $rv .= ' ( ';
        $rv .= $tableAlias.'.'.$oClause->alias.' ';
        if ( 'NULL' === $clauseValue ) {
          if ( '!=' == $oClause->sign || '<>' == $oClause->sign )
            $rv .= 'IS NOT '.$clauseValue;
          else
            $rv .= 'IS '.$clauseValue;
        } else {
          if ( is_array( $clauseValue ) ) {
            $sign = ( '!=' == $oClause->sign )
              ? 'NOT IN' : 'IN';
            $rv .= $sign.' ( '.System::implode( $clauseValue, ',' ).' )';
          } else {
            $rv .= $oClause->sign.' '.$clauseValue;
          }
        }
        $rv .= ' '
          . self::computeWhereGroup( $tableAlias, $oClause, true, $i );
        if ( $hasChildren )
          $rv .= ' ) ';
        $i++;
      }
      return $rv;
    }

    /**
     * @internal
     * @brief   Construit une jointure de la requête
     * @param   $leftTableAlias   string    alias de la table de gauche
     * @param   $struct           array     structure associée
     * @return  string
     */
    protected function computeJoin( $leftTableAlias, $struct ) {
      $rv = '';
      foreach( $struct AS $joinKey => $joinStruct )
        if ( array_key_exists( $leftTableAlias, $joinStruct ) )
          foreach( $joinStruct[ $leftTableAlias ] AS $joinOperator => $joinElements )
            foreach( $joinElements AS $idx => $elements )
              foreach( $elements AS $rightTableAlias => $fields ) {
                $rightTableName = $this->_getTableName( $rightTableAlias );
                $rv .= ' '.$joinOperator
                  . ' '.$rightTableName.' AS '.$rightTableAlias
                  . ' ON ( '.$leftTableAlias.'.'.$fields[ 0 ].' '.$fields[ 1 ].' '.$rightTableAlias.'.'.$fields[ 2 ];
                if ( array_key_exists( $joinKey, $this->_ItsJoinsWhere ) )
                  foreach( $this->_ItsJoinsWhere[ $joinKey ] AS $whereTableAlias => $whereStruct )
                    $rv .= ' '.$this->computeWhereGroup( $whereTableAlias, $whereStruct, true );
                $rv .= ' )';
                $rv .= $this->computeJoin( $rightTableAlias, $this->_ItsJoins );
              }
      return $rv;
    }

    /**
    * @brief    Crée une requête SQL de type SELECT
    * @return   string
    * @throw    Exception
    */
    public function select() {
      if ( 0 == count( $this->_ItsTables ) || 0 == count( $this->_ItsFields ) )
        throw new Exception( 'Données insuffisantes pour créer une requête' );
      $rv = 'SELECT ';
      // Ajout des champs
      /**
      * @todo Modifier cette partie du code pour pouvoir gérer des fonctions !
      */
      foreach( $this->_ItsFields AS $tableAlias => $tableFields )
        foreach( $tableFields AS $fieldName => $field )
          $rv .= ( (string)$field ).', ';
      $rv = substr( $rv, 0, strlen( $rv ) - 2 );
      // Ajout des tables
      $rv .= "\n".' FROM';
      $tmpTables = $this->getLeftTables();
      foreach( $tmpTables AS $tableAlias => $tableName ) {
        $rv .= ( !is_null( $tableAlias ) )
          ? ' '.$tableName.' AS '.$tableAlias : ' '.$tableName;
        // Ajout des jointures et de leurs contraintes
        $rv .= $this->computeJoin( $tableAlias, $this->_ItsJoins )
          . ',';
      }
      $rv = substr( $rv, 0, strlen( $rv ) - 1 );
      // Ajout des clauses where
      if ( count( $this->_ItsWhere ) > 0 ) {
        $rv .= "\n".' WHERE ';
        $i = 0;
        $appendOperator = false;
        foreach( $this->_ItsWhere AS $tableAlias => $struct ) {
          if ( $i > 0 )
            $appendOperator = true;
          $rv .= $this->computeWhereGroup( $tableAlias, $struct, $appendOperator );
          $i++;
        }
        $rv = substr( $rv, 0, strlen( $rv ) - 1 );
      }
      // Ajout des autres clauses (group by, having, order by)
      $clauses = array( self::ClauseGroupBy, self::ClauseHaving, self::ClauseOrderBy );
      foreach( $clauses AS $idx => $clauseType )
        if ( isset( $this->_clauses[ $clauseType ] ) )
          if ( count( $this->_clauses[ $clauseType ] ) > 0 ) {
            $rv .= "\n".' '.$clauseType.' ';
            $i = 0;
            foreach( $this->_clauses[ $clauseType ] AS $idx => $struct ) {
              if ( 0 != $i && isset( $struct[ 'operator' ] ) ) {
                $rv .= $struct[ 'operator' ];
                if ( !isset( $maxOperatorLen ) )
                  $maxOperatorLen = 0;
                $maxOperatorLen = max( $maxOperatorLen, strlen( $struct[ 'operator' ] ) );
              }
              if ( is_array( $struct[ 'value' ] ) )
                $rv .= $struct[ 'value' ][ 'table' ].'.'.$struct[ 'value' ][ 'field' ];
              else
                $rv .= $struct[ 'value' ];
              $i++;
            }
          }
      return $rv;
    }

    /**
     * @brief   Construit une requête de type UPDATE d'après les éléments chargés dans l'objet
     * @param   $tableAlias   string    le nom ou l'alias de la table cible
     * @code
     *   $sql =& new sqlBuilder();
     *   $alias = $sql->aliasTable( 'ma_table' );
     *   $sql->set( 'description', 'Description mise à jour', sqlBuilder::SqlTypeString );
     *   $sql->whereField( $alias, 'titre', 'Hello world!', '=', sqlBuilder::AndOperator );
     *   echo $sql->update( $alias );
     * @endcode
     */
    public function update( $tableAlias ) {
      $tableName = $this->_getTableName( $tableAlias );
      if ( is_null( $tableName ) )
        $tableName = $tableAlias;

      if ( '' != trim( $tableName ) ) {
        $set = '';
        foreach( $this->_updateInsertFields AS $fieldName => $fieldStruct ) {
          $fieldValue = $fieldStruct[ 'value' ];
          $set .= $fieldName.' = ';

          if ( is_bool( $fieldValue ) ) $fieldValue = (int)$fieldValue;
          elseif ( 0 == strlen( trim( $fieldValue ) ) ) $fieldValue = null;

          $set .= self::normalizeValue( $fieldValue, $fieldStruct[ 'type' ] ).', ';
        }
        if ( '' != $set )
          $set = substr( $set, 0, strlen( $set ) - 2 );
        //****

        // Ajout des clauses where
        $where = '';
        if ( count( $this->_ItsWhere ) > 0 ) {
          $i = 0;
          $appendOperator = false;
          foreach( $this->_ItsWhere AS $whereTableAlias => $struct ) {
            if ( $i > 0 )
              $appendOperator = true;
            $where .= $this->computeWhereGroup( $whereTableAlias, $struct, $appendOperator );
            $i++;
          }
          $where = substr( $where, 0, strlen( $where ) - 1 );
        }
        // ce type de requête ne pouvant attaquer qu'une seule table à la fois, on supprime les alias
        if ( '' != $where )
          $where = "\n".' WHERE '.str_replace( $tableAlias.'.', '', $where );

        return sprintf(
          'UPDATE %s SET %s%s',
          $tableName,
          $set,
          $where
        );
      } else {
        throw new Exception( 'Table non spécifiée' );
      }
    }

    /**
     * @brief   Construit une requête de type INSERT d'après les éléments chargés dans l'objet
     * @param   $tableAlias   string    le nom ou l'alias de la table cible
     * @code
     *   $sql =& new sqlBuilder();
     *   $sql->set( 'titre', 'Hello world!', sqlBuilder::SqlTypeString );
     *   $sql->set( 'description', 'Un exemple universel s\'il en est ;)', sqlBuilder::SqlTypeString );
     *   echo $sql->insert( 'ma_table' );
     * @endcode
     * @note    généralement on ne crée pas d'alias pour la table cible car un insert ne comporte pas de contrainte
     * @throw   Exception
     */
    public function insert( $tableAlias ) {
      $tableName = $this->_getTableName( $tableAlias );
      if ( is_null( $tableName ) )
        $tableName = $tableAlias;

      if ( '' != trim( $tableName ) ) {
        $tCibles = '';
        $tValues = '';
        foreach( $this->_updateInsertFields AS $fieldName => $fieldStruct ) {
          $fieldValue = $fieldStruct[ 'value' ];
          $tCibles .= $fieldName.', ';

          if ( is_bool( $fieldValue ) ) $fieldValue = (int)$fieldValue;
          elseif ( 0 == strlen( trim( $fieldValue ) ) ) $fieldValue = null;

          $tValues .= self::normalizeValue( $fieldValue, $fieldStruct[ 'type' ] ).', ';
        }
        if ( '' != $tCibles )
          $tCibles = substr( $tCibles, 0, strlen( $tCibles ) - 2 );
        if ( '' != $tValues )
          $tValues = substr( $tValues, 0, strlen( $tValues ) - 2 );
        return sprintf(
          'INSERT INTO %s( %s )'."\n".'VALUES( %s )',
          $tableName,
          $tCibles,
          $tValues
        );
      } else {
        throw new Exception( 'Table non spécifiée' );
      }
    }

    /**
     * @brief   Construit une requête de type DELETE d'après les éléments chargés dans l'objet
     * @param   $tableAlias   string    le nom ou l'alias de la table cible
     * @code
     *   $sql = new sqlBuilder();
     *   $alias = $oSql->aliasTable( 'ma_table' );
     *   $sql->whereField( $Alias, 'titre', 'Hello world!', '=', sqlBuilder::AndOperator );
     *   echo $sql->delete( $Alias );
     * @endcode
     * @throw   Exception
     */
    public function delete( $tableAlias ) {
      $tableName = $this->_getTableName( $tableAlias );
      if ( is_null( $tableName ) )
        $tableName = $tableAlias;

      if ( '' != $tableName ) {
        // Ajout des clauses where
        $where = '';
        if ( count( $this->_ItsWhere ) > 0 ) {
          $i = 0;
          $appendOperator = false;
          foreach( $this->_ItsWhere AS $whereTableAlias => $struct ) {
            if ( $i > 0 )
              $appendOperator = true;
            $where .= $this->computeWhereGroup( $whereTableAlias, $struct, $appendOperator );
            $i++;
          }
          $where = substr( $where, 0, strlen( $where ) - 1 );
        }
        // ce type de requête ne pouvant attaquer qu'une seule table à la fois, on supprime les alias
        if ( '' != $where )
          $where = "\n".' WHERE '.str_replace( $tableAlias.'.', '', $where );

        return sprintf(
          'DELETE FROM %s%s',
          $tableName,
          $where
        );
      } else {
        throw new Exception( 'Table non spécifiée' );
      }
    }
  }
?>