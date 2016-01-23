<?php
  /**
  * @class    FormChecker_Helper_RequiredUpload
  * @date     31-08-2006
  * @author   Jimmy CHARLEBOIS
  * @brief    Assistant vérifiant que le fichier à uploader l'a été
  * @note     Cet assistant est ajouté par défaut à tous les champs spécifiés comme obligatoire et de type FormChecker::TYPE_UPLOAD
  * @warning  Code basé sur celui généré par c.formrender.php
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerHelper' );

  class FormChecker_Helper_RequiredUpload implements IFormCheckerHelper {
    public static function check( FormChecker_Field &$oField, $params ) {
      $value = $oField->getValue();

      if ( !isset( $value[ 'value' ] ) )
        return $oField->raiseError( 'Wrong data structure for upload field' );
      $newValue = $value[ 'value' ];
      $oldValue = ( isset( $value[ 'old' ] ) ) ? $value[ 'old' ] : null;

      // Si on a une ancienne valeur et que rien de nouveau n'a été soumis, on s'arrête là
      if ( !is_null( $oldValue ) && ( UPLOAD_ERR_NO_FILE & $newValue[ 'error' ] ) )
        return true;

      // Il y a une nouvelle valeur > on vérifie le type mime si nécessaire
      if ( !is_null( $newValue[ 'tmp_name' ] ) && UPLOAD_ERR_OK == $newValue[ 'error' ] ) {
        if ( !is_null( $params ) && '*' != $params ) { // On a spécifié des types mimes autorisés
          $allowedTypes = explode( ';', $params );
          if ( is_null( $newValue[ 'type' ] ) )
            return $oField->raiseError( sprintf( 'Le type du fichier pour "%s" n\'a pu être déterminé', $oField->getLabel() ) );
          elseif ( !in_array( $newValue[ 'type' ], $allowedTypes ) )
            return $oField->raiseError( sprintf( '[%s] Ce type de fichier n\'est pas autorisé : %s', $oField->getLabel(), $params ) );
        }
        return true;
      }

      if ( UPLOAD_ERR_NO_FILE & $newValue[ 'error' ] )
        return ( !$oField->isRequired() )
          ? true
          : $oField->raiseError( sprintf( 'Veuillez remplir le champ "%s"', $oField->getLabel() ) );

      // Si on est pas encore sortie de la méthode c'est qu'il y a eu un soucis
      // on revérifie la valeur de $newValue[ 'error' ]
      if ( ( UPLOAD_ERR_INI_SIZE | UPLOAD_ERR_FORM_SIZE ) & $newValue[ 'error' ] ) {
        $maxSize = $oField->getForm()->getContext()->getParam( 'MAX_FILE_SIZE' );
        if ( is_null( $maxSize ) )
          $maxSize = ini_get( 'upload_max_filesize' );
        elseif ( is_numeric( $maxSize ) )
          $maxSize .= ' octets';
        return $oField->raiseError( sprintf( 'Le fichier "%s" est trop volumineux - limite %s', $oField->getLabel(), $maxSize ) );
      } elseif ( UPLOAD_ERR_PARTIAL & $newValue[ 'error' ] )
        return $oField->raiseError( sprintf( 'Le fichier "%s" n\'a pas été entièrement téléchargé', $oField->getLabel() ) );

      return false;
    }
  }
?>