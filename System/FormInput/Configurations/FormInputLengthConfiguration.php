<?php
  /**
   * @package     	FormInput
   * @class       	FormInputLengthConfiguration
   * @author      	Jimmy CHARLEBOIS
   * @date        	25-01-2007
   * @brief       	Classe pour élément de configuration de type longueur maximale
   */
  System::import( 'System.Interfaces.FormInput.IFormInputConfiguration' );
  System::import( 'System.BaseClass' );

  class FormInputLengthConfiguration extends BaseClass implements IFormInputConfiguration {
    private $_max_length;

    public function __construct( $max_len ) {
      parent::__construct();
      $this->_max_length = $max_len;
    }

    public function store() {
      return array(
        'max_length' => $this->_max_length
      );
    }

    public static function restore( $props ) {
      return new FormInputLengthConfiguration( $props[ 'max_length' ] );
    }

    /**
     * @brief   Retourne le nombre maximum de caractères défini
     * @return  integer
     */
    public function getMaxLength() {
      return $this->_max_length;
    }

    /** @brief    Implémentation de l'interface IFormInputConfiguration */
    /*@{*/
    public function getType() {
      return FormInputEnumeration::CONFIG_TYPE_LENGTH;
    }
    /*@}*/
  }
?>