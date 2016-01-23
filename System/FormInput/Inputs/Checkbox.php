<?php
  /**
   * @package       FormInput.Inputs
   * @class         Checkbox
   * @author        Jimmy CHARLEBOIS
   * @date          25-01-2007
   * @brief         Classe concrête pour case à cocher
   */
  System::import( 'System.FormInput.FormInput' );
  System::import( 'System.FormInput.FormInputEnumeration' );
  System::import( 'System.FormInput.Renderers.CheckboxRenderer' );

  class Checkbox extends FormInput {
    public function __construct( $name ) {
      parent::__construct( FormInputEnumeration::TYPE_CHECKBOX, $name );
      $this->setRenderer( new CheckboxRenderer( $this ) );
    }
  }
?>