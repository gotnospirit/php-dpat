<?php
  /**
  * @class  FormChecker_Helper_BirthdayFormat
  * @date   21-07-2006
  * @author Jimmy CHARLEBOIS
  * @brief  Assistant vérifiant le format d'une date
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerHelper' );

  class FormChecker_Helper_BirthdayFormat implements IFormCheckerHelper {
    public static function check( FormChecker_Field &$oField, $params ) {
      $value = $oField->getValue();
      if ( is_null( $value ) && !$oField->isRequired() )
        return true;
      switch( $params ) {
        case 'YYYY-mm-dd':
        case 'Y-m-d':
          $regPattern = '^[0-9]{4}-[0-9]{2}-[0-9]{2}$';
          break;
        case 'jj-mm-aaaa':
        case 'd-m-Y':
          $regPattern = '^[0-9]{2}-[0-9]{2}-[0-9]{4}$';
          break;
      }
      if ( !mb_eregi( $regPattern, $value ) )
        return $oField->raiseError( 'Mauvais format de date : '.$params );
      return true;
    }
  }
?>