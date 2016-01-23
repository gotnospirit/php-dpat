<?php
  /**
  * @class  FormChecker_Modifier_Uppercase
  * @date   13-06-2006
  * @author Jimmy CHARLEBOIS
  * @brief  Modificateur passant en haut de case la valeur du champ cible
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerModifier' );

  class FormChecker_Modifier_Uppercase implements IFormCheckerModifier {
    public function process( FormChecker_Field &$oField, $params = null ) {
      $oField->setValue( mb_strtoupper( $oField->getValue() ) );
    }
  }
?>