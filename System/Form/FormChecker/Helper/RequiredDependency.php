<?php
  /**
  * @class  FormChecker_Helper_RequiredDependency
  * @date   18-06-2007
  * @author Jimmy CHARLEBOIS
  * @brief  Assistant modifiant l'obligation de remplir un champ d�pendant d'un autre
  * @note   Par exemple, lorsqu'un champ doit �tre remplit seulement si on a remplit un autre champ
  * @warning  La v�rification du formulaire s'effectuant dans l'ordre dans lequel les champs ont �t� ajout�s le champ "ma�tre" doit bien evidemment �tre d�clar� avant le "d�pendant" 
  */
  class FormChecker_Helper_RequiredDependency implements IFormCheckerHelper {
    public static function check( FormChecker_Field &$oField, $params ) {
      if ( !is_array( $params ) || !array_key_exists( 'master', $params ) )
        return $oField->raiseError( sprintf( '"%s": RequiredDependency est mal configur�', $oField->getLabel() ) );

      $master_field =& $oField->getForm()->getField( $params[ 'master' ] );
      if ( is_null( $master_field ) )
        return $oField->raiseError( sprintf( 'Le champ "%s" n\'est pas d�fini pour ce formulaire', $params[ 'master' ] ) );

      $master_needed_value = ( array_key_exists( 'value', $params ) )
        ? $params[ 'value' ] : null;

      $rv = ( !is_null( $master_needed_value ) )
        ? ( $master_field->getValue() == $master_needed_value )
        : !is_null( $master_field->getValue() );

      return ( $rv )
        ? FormChecker_Helper_RequiredValue::check( $oField, null )
        : true;
    }
  }
?>