<?php
  /**
  * @class  FormChecker_Modifier_Upload
  * @date   08-06-2008
  * @author Jimmy CHARLEBOIS
  * @brief  Modificateur déplaçant le fichier uploadé
  */
  System::import( 'System.Interfaces.Form.FormChecker.IFormCheckerModifier' );

  class FormChecker_Modifier_Upload implements IFormCheckerModifier {
    public static function process( FormChecker_Field &$oField, $params ) {
      if ( !is_array( $params ) )
        $oField->raiseError( 'Les paramètres pour le fichier n\'ont pas été spécifiés' );

      if ( !isset( $params[ 'directory' ] ) )
        $oField->raiseError( 'Veuillez indiquer le répertoire de stockage' );
      if ( !isset( $params[ 'filename' ] ) && !isset( $params[ 'rename_callback' ] ) )
        $oField->raiseError( 'Veuillez indiquer le nom du fichier à stocker ou une callback de renommage' );
      if ( isset( $params[ 'rename_callback' ] ) && !is_callable( $params[ 'rename_callback' ] ) )
        $oField->raiseError( 'Callback introuvable' );

      if ( DIRECTORY_SEPARATOR != substr( $params[ 'directory' ], -1 ) )
        $params[ 'directory' ] .= DIRECTORY_SEPARATOR;

      $value = $oField->getValue();
      if ( !is_array( $value ) )
        $oField->raiseError( 'Wrong value format' );
      else {
        if ( !@file_exists( $params[ 'directory' ] ) )
          @mkdir( $params[ 'directory' ] );

        if ( isset( $params[ 'rename_callback' ] ) )
          $params[ 'filename' ] = call_user_func_array( $params[ 'rename_callback' ], array( $value[ 'name' ] ) );

        if ( !move_uploaded_file( $value[ 'tmp_name' ], $params[ 'directory' ].$params[ 'filename' ] ) )
          return $oField->raiseError( 'Le fichier n\'a pu être copié' );
        $oField->setValue( $params[ 'filename' ] );
      }
    }
  }
?>