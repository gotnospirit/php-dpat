<?php
  /**
  * @class  FormChecker_Helper_EqualValue
  * @date   04-06-2008
  * @author Jimmy CHARLEBOIS
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerHelper' );

  class FormChecker_Helper_EqualValue implements IFormCheckerHelper {
    public static function check( FormChecker_Field &$oField, $params ) {
      if ( is_array( $params ) || !isset( $params[ 'value' ] ) )
        return $oField->raiseError( 'La valeur attendue doit être scalaire' );
      if ( is_null( $oField->getValue() ) && !$oField->isRequired() )
        return true;
      if ( $oField->getValue() != $params[ 'value' ] ) {
        $err_msg = ( isset( $params[ 'error' ] ) )
          ? $params[ 'error' ]
          : sprintf( 'La valeur du champ "%s" n\'est pas valide', $oField->getLabel() );
        return $oField->raiseError( $err_msg );
      }
      return true;
    }
  }
?>