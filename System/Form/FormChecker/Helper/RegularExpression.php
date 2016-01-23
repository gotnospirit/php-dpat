<?php
  /**
  * @class  FormChecker_Helper_RegularExpression
  * @date   15-02-2006
  * @author Jimmy CHARLEBOIS
  * @brief  Assistant vérifiant la valeur du champ cible par une expression rationnelle
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerHelper' );

  class FormChecker_Helper_RegularExpression implements IFormCheckerHelper {
    public static function check( FormChecker_Field &$oField, $params ) {
      if ( is_null( $oField->getValue() ) && !$oField->isRequired() )
        return true;
      if ( !preg_match( $params[ 'pattern' ], $oField->getValue() ) )
        return $oField->raiseError( sprintf( $params[ 'error' ], $oField->getLabel() ) );
      return true;
    }
  }
?>