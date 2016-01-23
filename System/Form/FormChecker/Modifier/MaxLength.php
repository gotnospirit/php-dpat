<?php
  /**
  * @class  FormChecker_Modifier_MaxLength
  * @date   15-02-2006
  * @author Jimmy CHARLEBOIS
  * @brief  Modificateur limitant la taille de la valeur du champ
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerModifier' );

  class FormChecker_Modifier_MaxLength implements IFormCheckerModifier {
    public function process( FormChecker_Field &$oField, $params = null ) {
      if ( is_null( $params ) || !is_int( $params ) )
        throw new Exception( 'Please provide the maximum length as an integer parameter' );
      $oField->setValue( substr( $oField->getValue(), 0, $params ) );
    }
  }
?>