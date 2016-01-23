<?php
  /**
   * @package     	FormInput
   * @class       	FormInputConfiguration
   * @author      	Jimmy CHARLEBOIS
   * @date        	25-01-2007
   * @brief       	Classe d'encapsulation des propriétés de configuration d'un élément de formulaire
   */
  System::import( 'System.Interfaces.FormInput.IFormInputConfiguration' );
  System::import( 'System.BaseClass' );
  System::import( 'System.StoreObject' );

  class FormInputConfiguration extends BaseClass implements IFormInputConfiguration {
    private $_items;

    public function __construct() {
      parent::__construct();
      $this->_items = array();
    }

    public function store() {
      $item_data = array();
      foreach( $this->_items AS $key => $value )
        $item_data[ $key ] = StoreObject::store( $this->_items[ $key ] );
      return array(
        'items' => $item_data
      );
    }

    public static function restore( $props ) {
      $rv =& new FormInputConfiguration();
      foreach( $props[ 'items' ] AS $key => $value )
        $rv->add( StoreObject::restore( $value ) );
      return $rv;
    }

    /**
     * @brief   Retourne la configuration du type demandé
     * @param   $config_type    string    \ref FormConfigType
     * @return  IFormInputConfiguration|null
     */
    public function getConfig( $config_type ) {
      $rv = null;
      if ( array_key_exists( $config_type, $this->_items ) )
        $rv =& $this->_items[ $config_type ];
      return $rv;
    }

    /**
     * @brief   Ajoute un élément à la configuration
     * @return  void
     */
    public function add( IFormInputConfiguration &$config_item ) {
      $this->_items[ $config_item->getType() ] = $config_item;
    }

    /** @brief    Implémentation de l'interface IFormInputConfiguration */
    /*@{*/
    public function getType() {
      return FormInputEnumeration::CONFIG_TYPE_HOLDER;
    }
    /*@}*/
  }
?>