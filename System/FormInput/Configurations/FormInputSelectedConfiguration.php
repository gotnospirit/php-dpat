<?php
  /**
   * @package       FormInput
   * @class         FormInputSelectedConfiguration
   * @author        Jimmy CHARLEBOIS
   * @date          09-03-2007
   * @brief         Classe pour �l�ment de configuration de type �l�ment s�lectionn�
   */
  System::import( 'System.Interfaces.FormInput.IFormInputConfiguration' );
  System::import( 'System.BaseClass' );

  class FormInputSelectedConfiguration extends BaseClass implements IFormInputConfiguration {
    private $_selected;

    public function __construct( $is_selected = true ) {
      parent::__construct();
      $this->_selected = (bool)$is_selected;
    }

    public function store() {
      return array(
        'selected' => (int)$this->_selected
      );
    }

    public static function restore( $props ) {
      return new FormInputSelectedConfiguration( (bool)$props[ 'selected' ] );
    }

    /**
     * @brief   Indique si l'�l�ment doit �tre s�lectionn�
     * @return  boolean
     */
    public function isSelected() {
      return $this->_selected;
    }

    /** @brief    Impl�mentation de l'interface IFormInputConfiguration */
    /*@{*/
    public function getType() {
      return FormInputEnumeration::CONFIG_TYPE_SELECTED;
    }
    /*@}*/
  }
?>