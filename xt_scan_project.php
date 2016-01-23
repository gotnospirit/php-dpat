<?php
  /**
   * @author      	Jimmy CHARLEBOIS
   * @date        	27-04-2007
   * @brief         Scanne les fichiers php d'un répertoire donné et détermine quels fichiers de System devrons être copiés
   */
  require_once 'c.system.php';
  System::import( 'System.Context.ShellContext' );
  System::import( 'System.Context.RuntimeContext' );
  System::import( 'System.IO.SysDirectory' );
  System::import( 'System.ADT.Queue' );

  function help() {
    echo 'Scanne les fichiers php d\'un projet à la recherche des inclusions System::import() !'.System::crlf
      . 'Paramètres attendus :'.System::crlf
      . '1) répertoire de base du projet à scanner'.System::crlf
      . System::crlf
      . 'ou'.System::crlf
      . System::crlf
      . '--help:  Ce panneau d\'aide'.System::crlf;
  }

  function error( $msg ) {
    echo 'ERROR: '.$msg.System::crlf;
  }

  function find_files( $path, Queue &$result ) {
    $files = SysDirectory::getFiles( $path );
    $iterator =& $files->getIterator();
    while( $iterator->hasNext() ) {
      $entry =& $iterator->next();
      if ( 'php' == $entry->getExtension() ) {
        if ( !$result->contains( $entry ) )
          $result->enqueue( $entry );
      }
    }

    $dirs = SysDirectory::getDirectories( $path );
    if ( $dirs->size() > 0 ) {
      $iterator =& $dirs->getIterator();
      while( $iterator->hasNext() ) {
        $entry =& $iterator->next();
/*
        if ( $entry->getName() != '.' && $entry->getName() != '..' )
          find_files( (string)$entry, $result );
*/
      }
    }
  }

  function scan_file( SysFile $file, RuntimeContext &$shell ) {
    set_time_limit( 30 );

    try {
      $file->open( SysFile::READ_ACCESS );
      while( $line = $file->readLine() ) {
        $matches = array();
        preg_match( '~System::import\((.[^\*\)]*)\);~i', $line, $matches );
        if ( count( $matches ) > 0 ) {
          $classpath = str_replace( array( ' ', '\'', '"' ), '', $matches[ 1 ] );
          if ( !$shell->get( 'scan_results' )->contains( $classpath ) && ereg( '^System', $classpath ) )
            $shell->get( 'scan_results' )->enqueue( $classpath );
        }
      }
      $file->close();
    } catch( IOException $e ) {
      error( $e->getMessage().' "'.$file->getFilepath().'"' );
    }
  }

  $shell =& new RuntimeContext( new ShellContext() );
  $paramsHastable =& $shell->getParams();
  if ( $paramsHastable->size() != 2 || '--help' == $paramsHastable->get( 1 ) ) {
    help();
  } else {
    $path = $paramsHastable->get( 1 );
    if ( !SysDirectory::exists( $path ) )
      error( 'Le répertoire '.$path.' est inaccessible !' );
    else {
      $files =& new Queue();
      find_files( $path, $files );
      if ( 0 == $files->size() )
        error( 'Aucun fichier php a scanner' );
      else {
        $shell->set( 'scan_results', new Queue() );
        $iterator =& $files->getIterator();
        while( $iterator->hasNext() ) {
          $entry =& $iterator->next();
          scan_file( $entry, $shell );
        }
        unset( $files );

        $iterator =& $shell->get( 'scan_results' )->getIterator();
        while( $iterator->hasNext() ) {
          $filepath = System::find_class_filepath( $iterator->next() );
          scan_file( new SysFile( $filepath ), $shell );
        }

        $iterator =& $shell->get( 'scan_results' )->getIterator();
        while( $iterator->hasNext() ) {
          echo $iterator->next().System::crlf;
        }
      }
    }
  }
?>