<?php
  /**
  * @class  FormChecker_Helper_RequiredValue
  * @date   13-06-2006
  * @author Jimmy CHARLEBOIS
  * @brief  Assistant vérifiant que le champ cible n'est pas vide
  * @note   Cet assistant est ajouté par défaut à tous les champs spécifiés comme obligatoire
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerHelper' );

  class FormChecker_Helper_RequiredValue implements IFormCheckerHelper {
    /**
    * @brief  Vérifie qu'au moins une valeur du tableau n'est pas vide
    * @return boolean
    */
    private static function checkArrayNonEmpty( $tb ) {
      $rv = false;
      foreach( $tb AS $key => $value ) {
        if ( is_array( $value ) )
          $rv = self::checkArrayNonEmpty( $value );
        else
          $rv = mb_strlen( $value ) > 0;
        if ( $rv )
          break;
      }
      return $rv;
    }

    public static function check( FormChecker_Field &$oField, $params ) {
      $value = $oField->getValue();
      if ( is_array( $value ) )
        $rv = self::checkArrayNonEmpty( $value );
      else
        $rv = mb_strlen( $value ) > 0;
      if ( !$rv ) {
        if ( isset( $params[ 'error' ] ) )
          return $oField->raiseError( $params[ 'error' ] );
        else
          return $oField->raiseError( sprintf( 'Veuillez remplir le champ "%s"', $oField->getLabel() ) );
      }
      return true;
    }
  }
?>