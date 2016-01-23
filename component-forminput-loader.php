<?php
  /**
   * @author        Jimmy CHARLEBOIS
   * @date          04-01-2007
   * @brief         Exemple de chargement d'éléments de formulaire
   */
  error_reporting( E_ALL );
  require 'c.system.php';

  System::import( 'System.Context.HttpContext' );
  System::import( 'System.FormInput.FormInputFabrication' );
  System::import( 'System.FormInput.FormInput' );

  System::import( 'System.FormInput.FormInputConfiguration' );
  System::import( 'System.FormInput.Configurations.FormInputLengthConfiguration' );
  System::import( 'System.FormInput.Configurations.FormInputSelectedConfiguration' );

  //System::import( 'System.StoreObject' );

  $context =& new HttpContext();
  FormInput::setContext( $context );

  $configNom =& new FormInputConfiguration();
  $configNom->add( new FormInputLengthConfiguration( 10 ) );

  $configCheckbox =& new FormInputConfiguration();
  $configCheckbox->add( new FormInputSelectedConfiguration( false ) );

  $inputs = array(
    'nom' => array( 'type' => FormInputEnumeration::TYPE_TEXT, 'defaultValue' => 'Ab\'r"aham', 'configuration' => $configNom ), 
    'case_a_cocher' => array( 'type' => FormInputEnumeration::TYPE_CHECKBOX, 'defaultValue' => 1, 'configuration' => $configCheckbox ) 
  );

  foreach( $inputs AS $name => $struct ) {
    $$name =& FormInputFabrication::createNew( $struct[ 'type' ], $name );
    if ( array_key_exists( 'defaultValue', $struct ) )
      $$name->setDefaultValue( $struct[ 'defaultValue' ] );

    if ( array_key_exists( 'configuration', $struct ) )
      $$name->setConfiguration( $struct[ 'configuration' ] );
  }
/*
  System::export(
    StoreObject::restore(
      'a:2:{s:5:"class";s:9:"TextField";s:5:"props";a:5:{s:4:"name";s:8:"nom_copy";s:4:"type";s:4:"text";s:5:"value";N;s:13:"default_value";s:7:"Abraham";s:13:"configuration";s:200:"a:2:{s:5:"class";s:22:"FormInputConfiguration";s:5:"props";a:1:{s:5:"items";a:1:{s:6:"length";s:95:"a:2:{s:5:"class";s:28:"FormInputLengthConfiguration";s:5:"props";a:1:{s:10:"max_length";i:10;}}";}}}";}}'
    ),
    'restore TextField'
  );
*/
  if ( FormInput::hasUserInput() ) {
    System::export( 'Des données ont été soumises' );
    foreach( $inputs AS $name => $struct )
      System::export( $$name->getValue(), $name );
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Chargeur d'éléments de formulaire</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="StyleSheet" type="text/css" href="forminput.css" />
</head>
<body>
<form id="my_form" action="<?php echo $context->getParam( 'PHP_SELF' ); ?>" method="post">
<?php
  foreach( $inputs AS $name => $struct ) {
    echo '<fieldset>'.System::crlf
      . '<legend>'.$name.'</legend>'.System::crlf
      . 'Mode lecture : '.$$name->render( FormInputEnumeration::READ_VIEW ).'<hr />'
      . 'Mode édition : '.$$name->render( FormInputEnumeration::EDIT_VIEW ).'<hr />'
      . 'Mode recherche : '.$$name->render( FormInputEnumeration::SEARCH_VIEW )
      . '</fieldset>'.System::crlf
      ;
  }
?>
<p>
<input type="submit" name="submit" value="soumettre" />
</p>
</form>
</body>
</html>