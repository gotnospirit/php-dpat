<?php
  /**
  * @class  FormChecker_Modifier_Replace
  * @date   04-10-2006
  * @author Jimmy CHARLEBOIS
  * @brief  Modificateur retirant les caractères ne matchant pas l'expression rationnelle
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerModifier' );

  class FormChecker_Modifier_Replace implements IFormCheckerModifier {
    public function process( FormChecker_Field &$oField, $params = null ) {
      if ( !isset( $params[ 'pattern' ] ) )
        throw new Exception( 'Please provide the "pattern" parameter to the Replace modifier' );
      if ( !isset( $params[ 'replacement' ] ) )
        throw new Exception( 'Please provide the "replacement" parameter to the Replace modifier' );
      $oField->setValue( preg_replace( $params[ 'pattern' ], $params[ 'replacement' ], $oField->getValue() ) );
    }
  }
?>