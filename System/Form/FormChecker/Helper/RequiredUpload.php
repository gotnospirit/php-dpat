<?php
  /**
  * @class    FormChecker_Helper_RequiredUpload
  * @date     31-08-2006
  * @author   Jimmy CHARLEBOIS
  * @brief    Assistant v�rifiant que le fichier � uploader l'a �t�
  * @note     Cet assistant est ajout� par d�faut � tous les champs sp�cifi�s comme obligatoire et de type FormChecker::TYPE_UPLOAD
  * @warning  Code bas� sur celui g�n�r� par c.formrender.php
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerHelper' );

  class FormChecker_Helper_RequiredUpload implements IFormCheckerHelper {
    public static function check( FormChecker_Field &$oField, $params ) {
      $value = $oField->getValue();

      if ( !isset( $value[ 'value' ] ) )
        return $oField->raiseError( 'Wrong data structure for upload field' );
      $newValue = $value[ 'value' ];
      $oldValue = ( isset( $value[ 'old' ] ) ) ? $value[ 'old' ] : null;

      // Si on a une ancienne valeur et que rien de nouveau n'a �t� soumis, on s'arr�te l�
      if ( !is_null( $oldValue ) && ( UPLOAD_ERR_NO_FILE & $newValue[ 'error' ] ) )
        return true;

      // Il y a une nouvelle valeur > on v�rifie le type mime si n�cessaire
      if ( !is_null( $newValue[ 'tmp_name' ] ) && UPLOAD_ERR_OK == $newValue[ 'error' ] ) {
        if ( !is_null( $params ) && '*' != $params ) { // On a sp�cifi� des types mimes autoris�s
          $allowedTypes = explode( ';', $params );
          if ( is_null( $newValue[ 'type' ] ) )
            return $oField->raiseError( sprintf( 'Le type du fichier pour "%s" n\'a pu �tre d�termin�', $oField->getLabel() ) );
          elseif ( !in_array( $newValue[ 'type' ], $allowedTypes ) )
            return $oField->raiseError( sprintf( '[%s] Ce type de fichier n\'est pas autoris� : %s', $oField->getLabel(), $params ) );
        }
        return true;
      }

      if ( UPLOAD_ERR_NO_FILE & $newValue[ 'error' ] )
        return ( !$oField->isRequired() )
          ? true
          : $oField->raiseError( sprintf( 'Veuillez remplir le champ "%s"', $oField->getLabel() ) );

      // Si on est pas encore sortie de la m�thode c'est qu'il y a eu un soucis
      // on rev�rifie la valeur de $newValue[ 'error' ]
      if ( ( UPLOAD_ERR_INI_SIZE | UPLOAD_ERR_FORM_SIZE ) & $newValue[ 'error' ] ) {
        $maxSize = $oField->getForm()->getContext()->getParam( 'MAX_FILE_SIZE' );
        if ( is_null( $maxSize ) )
          $maxSize = ini_get( 'upload_max_filesize' );
        elseif ( is_numeric( $maxSize ) )
          $maxSize .= ' octets';
        return $oField->raiseError( sprintf( 'Le fichier "%s" est trop volumineux - limite %s', $oField->getLabel(), $maxSize ) );
      } elseif ( UPLOAD_ERR_PARTIAL & $newValue[ 'error' ] )
        return $oField->raiseError( sprintf( 'Le fichier "%s" n\'a pas �t� enti�rement t�l�charg�', $oField->getLabel() ) );

      return false;
    }
  }
?>