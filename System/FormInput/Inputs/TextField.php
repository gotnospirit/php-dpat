<?php
  /**
   * @package     	FormInput.Inputs
   * @class       	TextField
   * @author      	Jimmy CHARLEBOIS
   * @date        	12-01-2007
   * @brief       	Classe concrête pour champ de saisie
   */
  System::import( 'System.FormInput.FormInput' );
  System::import( 'System.FormInput.FormInputEnumeration' );
  System::import( 'System.FormInput.Renderers.TextFieldRenderer' );

  class TextField extends FormInput {
    public function __construct( $name ) {
      parent::__construct( FormInputEnumeration::TYPE_TEXT, $name );
      $this->setRenderer( new TextFieldRenderer( $this ) );
    }
  }
?>