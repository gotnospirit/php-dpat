<?php
  /**
  * @class  FormChecker_Modifier_Lowercase
  * @date   13-06-2006
  * @author Jimmy CHARLEBOIS
  * @brief  Modificateur passant en bas de case la valeur du champ cible
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerModifier' );

  class FormChecker_Modifier_Lowercase implements IFormCheckerModifier {
    public function process( FormChecker_Field &$oField, $params = null ) {
      $oField->setValue( mb_strtolower( $oField->getValue() ) );
    }
  }
?>