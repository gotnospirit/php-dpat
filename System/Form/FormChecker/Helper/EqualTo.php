<?php
  /**
  * @class  FormChecker_Helper_EqualTo
  * @date   13-06-2006
  * @author Jimmy CHARLEBOIS
  * @brief  Assistant vérifiant que le champ cible est égal à ceux fournis en paramètre de la méthode check
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerHelper' );

  class FormChecker_Helper_EqualTo implements IFormCheckerHelper {
    public static function check( FormChecker_Field &$oField, $params ) {
      $fields = array();
      if ( is_array( $params ) ) {
        foreach( $params AS $idx => $fieldName ) {
          $tmpField = $oField->getForm()->getField( $fieldName );
          if ( !is_null( $tmpField ) )
            $fields[] =& $tmpField;
        }
      } else {
        $tmpField = $oField->getForm()->getField( $params );
        if ( !is_null( $tmpField ) )
          $fields[] =& $tmpField;
      }
      $rv = true;
      foreach( $fields AS $idx => &$tmpField )
        if ( $oField->getValue() != $tmpField->getValue() )
          $rv = false;

      return ( !$rv )
        ? $oField->raiseError( sprintf( 'Le champ "%s" ne correspond pas', $oField->getLabel() ) )
        : true;
    }
  }
?>