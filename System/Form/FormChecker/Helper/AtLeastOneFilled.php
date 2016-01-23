<?php
  /**
  * @class  FormChecker_Helper_AtLeastOneFilled
  * @date   07-09-2006
  * @author Jimmy CHARLEBOIS
  * @brief  Assistant vérifiant qu'au moins un champ (cible ou params) est remplit
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerHelper' );
  System::import( 'System.Form.FormChecker.Helper.RequiredValue' );

  class FormChecker_Helper_AtLeastOneFilled implements IFormCheckerHelper {
    public static function check( FormChecker_Field &$oField, $params ) {
      $fields = array( clone( $oField ) );
      if ( is_array( $params ) ) {
        foreach( $params AS $idx => $fieldName ) {
          $tmpField = $oField->getForm()->getField( $fieldName );
          if ( !is_null( $tmpField ) )
            $fields[] = clone( $tmpField );
        }
      } else {
        $tmpField = $oField->getForm()->getField( $params );
        if ( !is_null( $tmpField ) )
          $fields[] = clone( $tmpField );
      }
      // on a cloner les objets afin de ne pas lancer d'erreur lors de la phase qui suit
      $rv = false;
      foreach( $fields AS $idx => $tmpField ) {
        if ( FormChecker_Helper_RequiredValue::check( $tmpField, null ) )
          $rv = true;
      }

      if ( $rv )
        return true;
      else {
        $fieldNames = '';
        foreach( $fields AS $idx => &$tmpField )
          $fieldNames .= '"'.$tmpField->getLabel().'",';
        $fieldNames = substr( $fieldNames, 0, strlen( $fieldNames ) - 1 );
        return $oField->raiseError( sprintf( 'Veuillez remplir au moins un des champs %s', $fieldNames ) );
      }
    }
  }
?>