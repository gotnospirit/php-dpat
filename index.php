<?php
  require 'c.system.php';

  System::import( 'System.Context.HttpContext' );
  System::import( 'System.IO.SysDirectory' );
  System::import( 'System.IO.SysFile' );

  $context =& new HttpContext();
  $tmpfile = new SysFile( $context->getParam( 'SCRIPT_FILENAME' ) );
  $files = SysDirectory::getFiles( $tmpfile->getDirectoryName() );

  $items = array();
  if ( count( $files ) > 0 ) {
    $iterator =& $files->getIterator();
    while( $iterator->hasNext() ) {
      $file = $iterator->next();
      if ( 'php' == $file->getExtension() ) {
        $filename = $file->getFilename();
        $matches = array();
        preg_match( '|([a-z0-9_]+)\-([a-z0-9_]+)\-loader|', $filename, $matches );
        if ( count( $matches ) > 0 ) {
          $type = ucfirst( $matches[ 1 ] );
          if ( !array_key_exists( $type, $items ) )
            $items[ $type ] = array();
          $items[ $type ][ $filename ] = ucfirst( $matches[ 2 ] );
        }
      }
    }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Liste des exemples</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
  <h1>Liste des fichiers du répertoire <?php echo $tmpfile->getDirectoryName(); ?></h1>
<?php
  if ( count( $items ) > 0 ) {
    foreach( $items AS $type => $files ) {
      echo '<h2>'.$type.'</h2>'
        . "<ul>\n";
      foreach( $files AS $filename => $name )
        echo '<li><a href="'.$filename.'">'.$name."</a></li>\n";
      echo "</ul>\n";
    }
  }
?>
<a href="docs/html/index.htm">Documentation</a>
</body>
</html>