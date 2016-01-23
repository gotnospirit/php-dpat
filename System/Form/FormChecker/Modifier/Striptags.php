<?php
  /**
  * @class  FormChecker_Modifier_Striptags
  * @date   13-06-2006
  * @author Jimmy CHARLEBOIS
  * @brief  Modificateur supprimant les entités html
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerModifier' );

  class FormChecker_Modifier_Striptags implements IFormCheckerModifier {
    public function process( FormChecker_Field &$oField, $params = null ) {
      $oField->setValue( strip_tags( $oField->getValue() ) );
    }
  }
?>