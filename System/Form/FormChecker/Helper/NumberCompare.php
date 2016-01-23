<?php
  /**
  * @class  FormChecker_Helper_NumberCompare
  * @date   21-03-2008
  * @author Jimmy CHARLEBOIS
  * @brief  Assistant vérifiant la valeur du champ cible en la comparant avec le champ "source"
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerHelper' );

  class FormChecker_Helper_NumberCompare implements IFormCheckerHelper {
    public static function check( FormChecker_Field &$oField, $params ) {
      $source = $oField->getForm()->getField( $params[ 'source' ] );
      $cmp_sign = 0;
      $source = (int)$source->getValue();
      $field = (int)$oField->getValue();
      if ( $source < $field )
        $cmp_sign = -1;
      elseif ( $source > $field )
        $cmp_sign = 1;

      if ( $cmp_sign !== $params[ 'sign' ] )
        return $oField->raiseError( $params[ 'error' ] );

      return true;
    }
  }
?>