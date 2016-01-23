<?php
  /**
   * @package     	FormInput
   * @class       	FormInputFabrication
   * @author      	Jimmy CHARLEBOIS
   * @date        	12-01-2007
   * @brief       	Fabrique d'élément de formulaire
   */
  System::import( 'System.FormInput.FormInputEnumeration' );

  class FormInputFabrication {
    /**
     * @brief   Instancie et retourne un élément de formulaire
     * @param   $enum_const   const     \ref FormInputType
     * @param   $input_name   string    Nom de l'élément
     * @return  FormInput
     * @throw   Exception
     */
    public static function createNew( $enum_const, $input_name ) {
      $rv = null;
      if ( FormInputEnumeration::TYPE_TEXT == $enum_const ) {
        System::import( 'System.FormInput.Inputs.TextField' );
        $rv =& new TextField( $input_name );
      } elseif( FormInputEnumeration::TYPE_CHECKBOX == $enum_const ) {
        System::import( 'System.FormInput.Inputs.Checkbox' );
        $rv =& new Checkbox( $input_name );
      }
      if ( !is_null( $rv ) )
        FormInput::registerItem( $rv );
      return $rv;
    }
  }
?>