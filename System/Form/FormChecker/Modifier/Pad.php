<?php
  /**
  * @class  FormChecker_Modifier_Pad
  * @date   06-09-2006
  * @author Jimmy CHARLEBOIS
  * @brief  Modificateur complétant la longueur de la valeur du champ sur lequel il est appliqué
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerModifier' );

  class FormChecker_Modifier_Pad implements IFormCheckerModifier {
    public function process( FormChecker_Field &$oField, $params = null ) {
      if ( !isset( $params[ 'char' ] ) )
        throw new Exception( 'Please provide the "char" parameter to the Pad modifier' );
      if ( !isset( $params[ 'len' ] ) )
        throw new Exception( 'Please provide the "len" parameter to the Pad modifier' );
      $padType = STR_PAD_BOTH;
      if ( isset( $params[ 'type' ] ) ) {
        if ( 'left' == $params[ 'type' ] )
          $padType = STR_PAD_LEFT;
        elseif ( 'right' == $params[ 'type' ] )
          $padType = STR_PAD_RIGHT;
      }
      $oField->setValue( str_pad( $oField->getValue(), $params[ 'len' ], $params[ 'char' ], $padType ) );
    }
  }
?>