<?php
  /**
   * @package       Form
   * @class         FormChecker
   * @author        Jimmy CHARLEBOIS
   * @date          13-06-2006
   * @brief         Représentation d'un formulaire à vérifier
   */
  System::import( 'System.Interfaces.MVC.IModel' );
  System::import( 'System.Form.FormChecker.Field' );
  System::import( 'System.Form.FormChecker.Helper.*' );
  System::import( 'System.Form.FormChecker.Modifier.*' );

  class FormChecker implements IModel {
    private $_ItsFields;
    private $_ItsErrors;

    /** @brief    Contexte d'exécution partagé par tous les éléments */
    private static $_context    = null;

    const REQUIRED = true;

    const TYPE_TEXT = 1;
    const TYPE_SELECT = 2;
    const TYPE_NUMERIC = 4;
    const TYPE_FLOAT = 8;
    const TYPE_RADIO = 16;
    const TYPE_CHECKBOX = 32;
    const TYPE_UPLOAD = 64;

    public function __construct() {
      if ( is_null( self::$_context ) )
        throw new Exception( 'Context must be defined' );
      $this->_ItsFields = array();
      $this->_ItsErrors = array();
    }

    /**
     * @brief   Définit le contexte d'exécution associé aux éléments de formulaire
     * @param   $context    Context   Contexte d'exécution
     * @return  void
     */
    public static function setContext( IContext &$context ) {
      self::$_context = $context;
    }

    /**
     * @brief   Retourne le contexte d'exécution
     * @return  Context
     */
    public function &getContext() {
      return self::$_context;
    }

    /**
    * @brief  Retourne une collection des erreurs survenues au niveau du formulaire
    * @note   généralement ces erreurs sont ajoutés par l'extérieur de la classe
    * @return array
    */
    public function getInternalErrors() { return $this->_ItsErrors; }

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
    * @brief  Ajoute un contrôle de valeur à un champ déclaré du formulaire
    * @param  $name       string                  nom du champ cible
    * @param  $className  string                  le nom de la classe contrôle
    * @param  $params     string|array  optional  un ou une collection de champ faisant partie du formulaire
    * @return void
    */
    public function addHelper( $name, $className, $params = null ) {
      if ( !isset( $this->_ItsFields[ $name ] ) )
        throw new Exception( 'Can\'t find field `'.$name.'`' );
      $className = 'FormChecker_Helper_'.$className;
      if ( !class_exists( $className ) )
        throw new Exception( 'Cannot load helper class file : '.$className );
      $this->_ItsFields[ $name ]->addHelper( $className, $params );
    }

    /**
    * @brief  Ajoute un modificateur de valeur à un champ déclaré du formulaire
    * @param  $name       string                  nom du champ cible
    * @param  $className  string                  le nom de la classe modificateur
    * @param  $params     string|array  optional  un ou une collection de champ faisant partie du formulaire
    * @return void
    */
    public function addModifier( $name, $className, $params = null ) {
      if ( !isset( $this->_ItsFields[ $name ] ) )
        throw new Exception( 'Can\'t find field `'.$name.'`' );
      $className = 'FormChecker_Modifier_'.$className;
      if ( !class_exists( $className ) )
        throw new Exception( 'Cannot load modifier class file : '.$className );
      $this->_ItsFields[ $name ]->addModifier( $className, $params );
    }

    /**
    * @brief  Retourne la collection des objets FormChecker_Field déclaré pour le formulaire
    * @return array
    */
    public function &getFields() { return $this->_ItsFields; }

    /**
    * @brief  Retourne un objet FormChecker_Field déclaré
    * @param  $name       nom du champ cible
    * @return FormChecker_Field
    */
    public function &getField( $name ) {
      $rv = null;
      if ( isset( $this->_ItsFields[ $name ] ) )
        $rv =& $this->_ItsFields[ $name ];
      return $rv;
    }

    /**
    * @brief  Retourne une collection des valeurs des champs
    * @return array
    */
    public function &getFieldsValue() {
      $rv = array();
      foreach( $this->_ItsFields AS $name => $object ) {
        $value = $object->getValue();
        if ( is_null( $value ) )
          $value = $object->getDefaultValue();
        $rv[ $name ] = $value;
      }
      return $rv;
    }

    /**
    * @brief  Déclare un champ pour le formulaire
    * @param  $name     string            nom du champ cible
    * @param  $type     const             type du champ
    * @param  $required boolean optional  indique si le champ est obligatoire
    * @param  $label    string  optional  libellé du champ (pour les erreurs)
    * @return void
    */
    public function addField( $name, $type, $required = true, $label = null ) {
      $allowedTypes = array(
        self::TYPE_TEXT, self::TYPE_SELECT, self::TYPE_NUMERIC,
        self::TYPE_FLOAT, self::TYPE_RADIO, self::TYPE_CHECKBOX,
        self::TYPE_UPLOAD
      );
      if ( !in_array( $type, $allowedTypes ) )
        throw new Exception( 'Unsupported field type' );
      $this->_ItsFields[ $name ] = new FormChecker_Field( $this, $type, $name, $label, $required );
      if ( $required )
        $this->addHelper( $name, 'RequiredValue' );
    }

    /**
    * @brief  Retourne une collection des erreurs survenues pour les champs du formulaire
    * @return array
    */
    public function getErrors() {
      $rv = array();
      foreach( $this->_ItsFields AS $name => &$oFormCheckerField )
        if ( $oFormCheckerField->errorOccured() )
          $rv[ $name ] = $oFormCheckerField->getErrors();
      return $rv;
    }

    /**
    * @brief  Indique si au moins une erreur est survenue pour le formulaire (ou ces champs)
    * @return boolean
    */
    public function errorOccured() {
      $rv = count( $this->_ItsErrors ) > 0;
      if ( !$rv )
        foreach( $this->_ItsFields AS $name => &$oFormCheckerField )
          if ( $oFormCheckerField->errorOccured() ) {
            $rv = true;
            break;
          }
      return $rv;
    }

    /**
    * @brief  Demande la vérification des champs du formulaire
    * @return boolean
    */
    public function check() {
      $rv = true;
      foreach( $this->_ItsFields AS $name => &$oFormCheckerField ) {
        $tmp = $oFormCheckerField->check();
        if ( $tmp === false )
          $rv = false;
      }
      return $rv && !$this->errorOccured();
    }

    /**
    * @brief  Demande l'application des modificateurs assignés aux champs du formulaire
    * @return boolean
    */
    public function process() {
      foreach( $this->_ItsFields AS $name => &$oFormCheckerField )
        $oFormCheckerField->applyModifiers();
      return !$this->errorOccured();
    }
  }
?>