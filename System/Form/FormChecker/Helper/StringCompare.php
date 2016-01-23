<?php
  /**
  * @class  FormChecker_Helper_StringCompare
  * @date   03-08-2007
  * @author Jimmy CHARLEBOIS
  * @brief  Assistant vérifiant la valeur du champ cible en la comparant avec le champ "source"
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerHelper' );

  class FormChecker_Helper_StringCompare implements IFormCheckerHelper {
    public static function check( FormChecker_Field &$oField, $params ) {
      $source = $oField->getForm()->getField( $params[ 'source' ] );
      if ( strcmp( $source->getValue(), $oField->getValue() ) == $params[ 'sign' ] )
        return $oField->raiseError( $params[ 'error' ] );
      return true;
    }
  }
?>