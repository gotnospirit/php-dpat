<?php
  /**
   * @package     	FormInput
   * @class       	FormInput
   * @author      	Jimmy CHARLEBOIS
   * @date        	12-01-2007
   * @brief       	Classe abstraite pour élément de formulaire
   */
  System::import( 'System.Interfaces.FormInput.IFormInput' );
  System::import( 'System.Interfaces.FormInput.IFormInputConfiguration' );
  System::import( 'System.BaseClass' );
  System::import( 'System.StoreObject' );

  abstract class FormInput extends BaseClass implements IFormInput {
    private $_name;
    private $_type;
    private $_value;
    private $_default_value;
    private $_configuration;
    private $_renderer;

    /** @brief    Contexte d'exécution partagé par tous les éléments de formulaire */
    private static $_context    = null;
    /** @brief    Collection des éléments de formulaire instanciés */
    private static $_inputs     = array();

    public function __construct( $type, $name ) {
      parent::__construct();
      $this->_name = $name;
      $this->_type = $type;

      if ( !is_null( self::$_context ) && self::$_context->hasParam( $name ) )
        $this->_value = self::$_context->getParam( $name );
      else
        $this->_value = null;

      $this->_default_value = null;
      $this->_configuration = null;

      $this->_renderer = null;
    }

    public function store() {
      return array(
        'name' => $this->_name,
        'type' => $this->_type,
        'value' => $this->_value,
        'default_value' => $this->_default_value,
        'configuration' => StoreObject::store( $this->_configuration )
      );
    }

    public static function restore( $props ) {
      $rv =& FormInputFabrication::createNew( $props[ 'type' ], $props[ 'name' ] );
      $rv->_value = $props[ 'value' ];
      $rv->_default_value = $props[ 'default_value' ];
      $rv->_configuration = StoreObject::restore( $props[ 'configuration' ] );
      return $rv;
    }

    /**
     * @brief   Retourne l'objet qui permet le rendu de l'élément de formulaire
     * @return  IFormInputRenderer
     */
    public function &getRenderer() {
      return $this->_renderer;
    }

    /**
     * @brief   Définit l'objet qui va permettre le rendu de l'élément de formulaire
     * @param   $renderer   IFormInputRenderer
     * @return  void
     */
    public function setRenderer( IFormInputRenderer &$renderer ) {
      $this->_renderer =& $renderer;
    }

    /**
     * @brief   Définit les propriétés de configuration de l'élément
     * @return  void
     */
    public function setConfiguration( IFormInputConfiguration &$config ) {
      $this->_configuration = $config;
    }

    /**
     * @brief   Retourne les propriétés de configuration de l'élément
     * @return  void
     */
    public function getConfiguration() {
      return $this->_configuration;
    }

    public function getInputName() {
      return $this->_name;
    }

    public function setValue( $value ) {
      $this->_value = $value;
    }

    public function getValue() {
      return $this->_value;
    }

    public function getType() {
      return $this->_type;
    }

    public function setDefaultValue( $value ) {
      $this->_default_value = $value;
    }

    public function getDefaultValue() {
      return $this->_default_value;
    }

    /**
     * @brief   Enregistre un élément de formulaire
     * @param   $input    IFormInput    L'élément de formulaire à enregistrer
     * @see     FormInputFabrication::createNew
     * @throw   Exception
     */
    public static function registerItem( IFormInput &$input ) {
      if ( is_null( self::$_inputs ) )
        self::$_inputs = array();
      if ( array_key_exists( $input->getInputName(), self::$_inputs ) )
        throw new Exception( 'Input `'.$input->getInputName().'`already registered !' );
      self::$_inputs[ $input->getInputName() ] =& $input;
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
     * @brief   Indique si des données ont été soumises par l'utilisateur
     * @return  boolean
     */
    public static function hasUserInput() {
      $rv = false;
      foreach( self::$_inputs AS $input_name => $input )
        if ( self::$_context->hasParam( $input_name ) ) {
          $rv = true;
          break;
        }
      return $rv;
    }

    public function render( $view_type ) {
      $rv = null;
      if ( is_null( $this->_renderer ) )
        throw new Exception( 'Renderer not defined' );

      if ( FormInputEnumeration::READ_VIEW == $view_type )
        $rv = $this->_renderer->renderRead();
      elseif ( FormInputEnumeration::EDIT_VIEW == $view_type )
        $rv = $this->_renderer->renderEdit();
      elseif ( FormInputEnumeration::SEARCH_VIEW == $view_type )
        $rv = $this->_renderer->renderSearch();
      return $rv;
    }
  }
?>