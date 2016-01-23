<?php
  /**
  * @class  FormChecker_Helper_EmailFormat
  * @date   13-06-2006
  * @author Jimmy CHARLEBOIS
  * @brief  Assistant vérifiant le format d'un champ de type adresse de messagerie
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerHelper' );

  class FormChecker_Helper_EmailFormat implements IFormCheckerHelper {
    public static function check( FormChecker_Field &$oField, $params ) {
      $value = $oField->getValue();
      if ( is_null( $value ) && !$oField->isRequired() )
        return true;

      if ( !mb_eregi( '^[a-z0-9\._-]+@[a-z0-9\._-]+$', $value ) )
//      if ( !mb_eregi( '^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $value ) )
        return $oField->raiseError( 'Votre email n\'est pas correct' );
      else {
        $tmp = explode( '@', $value );
        if ( !is_array( $tmp ) )
          return false;
        elseif ( !dns_check_record( $tmp[ 1 ], 'MX' ) )
          return $oField->raiseError( 'Votre nom de domaine n\'est pas valide, veuillez vérifier votre saisie' );
      }
      return true;
    }
  }
?>