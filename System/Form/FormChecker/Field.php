<?php
  /**
   * @package       Form
   * @class         FormChecker_Field
   * @author        Jimmy CHARLEBOIS
   * @date          13-06-2006
   * @brief         Représentation d'un champ de formulaire
   */
  class FormChecker_Field {
    private $_ItsFormChecker;
    private $_ItsLabel;
    private $_ItsName;
    private $_ItsType;
    private $_ItsIsRequired;
    private $_ItsHelpers;
    private $_ItsModifiers;
    private $_ItsErrors;
    private $_ItsValue;
    private $_defaultValue;

    public function __construct( FormChecker &$oFormChecker, $type, $name, $label, $required = true ) {
      $this->_ItsFormChecker =& $oFormChecker;
      $this->_ItsName = $name;
      $this->_ItsLabel = $label;
      $this->_ItsType = $type;
      $this->_ItsIsRequired = $required;
      $this->_ItsHelpers = array();
      $this->_ItsModifiers = array();
      $this->_ItsErrors = array();
      $this->_ItsValue = $this->_ItsFormChecker->getContext()->getParam( $name );
      $this->_defaultValue = null;
    }

    /**
     * @brief   Définit la valeur par défaut du champ
     * @param   $value    mixed   la valeur par défaut du champ
     * @return  void
     */
    public function setDefaultValue( $value ) {
      $this->_defaultValue = $value;
    }

    /**
     * @brief   Retourne la valeur par défaut du champ
     * @return  mixed
     * @see     FormChecker::getFieldsValue
     */
    public function getDefaultValue() {
      return $this->_defaultValue;
    }

    /**
    * @brief  Retourne l'objet FormChecker qui a instancié le champ
    * @return FormChecker
    */
    public function getForm() { return $this->_ItsFormChecker; }

    /**
    * @brief  Retourne la collection des erreurs survenues pour le champ
    * @return array
    */
    public function getErrors() { return $this->_ItsErrors; }

    /**
    * @brief  Ajoute une erreur au champ
    * @param  $txt  string  le message d'erreur
    * @return false
    */
    public function raiseError( $txt ) {
      $this->_ItsErrors[] = $txt;
      return false;
    }

    /**
    * @brief  Indique si au moins une erreur est survenue
    * @return boolean
    */
    public function errorOccured() { return count( $this->_ItsErrors ) > 0; }

    /**
    * @brief  Indique si le champ est obligatoire
    * @return boolean
    */
    public function isRequired() { return $this->_ItsIsRequired; }

    /**
    * @brief  Retourne le libellé du champ
    * @return string
    */
    public function getLabel() { return $this->_ItsLabel; }

    /**
    * @brief  Retourne le nom du champ
    * @return string
    */
    public function getName() { return $this->_ItsName; }

    /**
    * @brief  Retourne la valeur du champ
    * @return mixed
    */
    public function getValue() { return $this->_ItsValue; }

    /**
    * @brief  Définit la valeur du champ
    * @param  $value  mixed la valeur a assigner
    * @return mixed
    */
    public function setValue( $value ) { $this->_ItsValue = $value; }

    /**
    * @brief  Ajoute un contrôle de valeur
    * @param  $className  string                  le nom de la classe contrôle
    * @param  $params     string|array  optional  un ou une collection de champ faisant partie du formulaire
    * @return void
    */
    public function addHelper( $className, $params = null ) {
//      if ( !array_key_exists( $className, $this->_ItsHelpers ) )
        $this->_ItsHelpers[ $className ] = $params;
    }

    /**
    * @brief  Ajoute un modificateur de valeur
    * @param  $className  string        le nom de la classe contrôle
    * @param  $params     string|array  optional  un ou une collection de champ faisant partie du formulaire
    * @return void
    */
    public function addModifier( $className, $params = null ) {
//      if ( !array_key_exists( $className, $this->_ItsModifiers ) )
        $this->_ItsModifiers[ $className ] = $params;
    }

    /**
    * @brief  Demande l'application des modifieurs sur la valeur du champ
    * @return void
    */
    public function applyModifiers() {
      if ( is_null( $this->_ItsValue ) )
        return ;
      try {
        foreach( $this->_ItsModifiers AS $modifierClassName => $params ) {
          if ( !is_callable( array( $modifierClassName, 'process' ) ) )
            throw new Exception( 'Non-callable modifier `'.$modifierClassName.'`' );
          call_user_func_array( array( $modifierClassName, 'process' ), array( &$this, $params ) );
        }
      } catch( Exception $err ) {
        $this->raiseError( $err->getMessage() );
      }
    }

    /**
    * @brief  Vérifie la validité du champ via ces helpers
    * @return boolean
    */
    public function check() {
      $rv = true;
      try {
        foreach( $this->_ItsHelpers AS $helperClassName => $params ) {
          if ( !is_callable( array( $helperClassName, 'check' ) ) )
            throw new Exception( 'Non-callable checker `'.$helperClassName.'`' );
          $tmp = call_user_func_array( array( $helperClassName, 'check' ), array( &$this, $params ) );
          if ( $this->errorOccured() || $tmp === false ) {
            $rv = false;
            break;
          }
        }
      } catch( Exception $err ) {
        $rv = false;
      }
      return $rv;
    }
  }
?>