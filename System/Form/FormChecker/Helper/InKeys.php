<?php
  /**
  * @class  FormChecker_Helper_InKeys
  * @date   27-09-2007
  * @author Jimmy CHARLEBOIS
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerHelper' );

  class FormChecker_Helper_InKeys implements IFormCheckerHelper {
    public static function check( FormChecker_Field &$oField, $params ) {
      if ( !is_array( $params ) )
        return $oField->raiseError( 'Les clés possibles doivent être fournies via un tableau associatif' );
      if ( is_null( $oField->getValue() ) && !$oField->isRequired() )
        return true;
      if ( !array_key_exists( $oField->getValue(), $params ) )
        return $oField->raiseError( sprintf( 'La clé "%s" n\'est pas permise pour le champ "%s"', $oField->getValue(), $oField->getLabel() ) );
      return true;
    }
  }
?>