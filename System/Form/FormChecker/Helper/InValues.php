<?php
  /**
  * @class  FormChecker_Helper_InValues
  * @date   07-09-2007
  * @author Jimmy CHARLEBOIS
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerHelper' );

  class FormChecker_Helper_InValues implements IFormCheckerHelper {
    public static function check( FormChecker_Field &$oField, $params ) {
      if ( !is_array( $params ) )
        return $oField->raiseError( 'Les valeurs possibles doivent être fournies via un tableau' );
      if ( is_null( $oField->getValue() ) && !$oField->isRequired() )
        return true;
      if ( !in_array( $oField->getValue(), $params ) )
        return $oField->raiseError( sprintf( 'La valeur "%s" n\'est pas permise pour le champ "%s"', $oField->getValue(), $oField->getLabel() ) );
      return true;
    }
  }
?>