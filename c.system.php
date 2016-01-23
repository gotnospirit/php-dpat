<?php
  /**
  * @static
  * @class          System
  * @author         Jimmy CHARLEBOIS
  * @date           27-10-2006
  * @brief          Implémentation statique de quelques méthodes génériques
  */
  class System {
    private static $_basedir = null;
    private static $_alternativeIncludeDir = array();

    private static $_errors = array();
    private static $_errLevel = 0;

    const INCLUDE_DIR = true;
    const crlf = PHP_EOL;

    public static function addIncludeDirectory( $dirname ) {
      if ( substr( $dirname, -1 ) != DIRECTORY_SEPARATOR )
        $dirname .= DIRECTORY_SEPARATOR;
      if ( !in_array( $dirname, self::$_alternativeIncludeDir ) )
        self::$_alternativeIncludeDir[] = $dirname;
    }

    /**
     * @brief   Définit le chemin de l'application
     * @param   $dirname    string    chemin de l'application
     * @return  void
     */
    public static function setBaseDirectory( $dirname ) {
      self::$_basedir = $dirname;
    }

    /**
     * @brief   Définit le niveau d'erreur
     * @param   $errLevel   integer   niveau d'erreur à reporter
     * @return  void
     */
    public static function errorLevel( $errLevel ) {
      self::$_errLevel = $errLevel;
    }

    /**
     * @brief   Lance une erreur système
     * @param   $msg    string    message d'erreur
     * @return  void
     */
    public static function throwError( $msg ) {
      if ( self::$_errLevel != 0 )
        self::$_errors[] = $msg;
      else
        throw new Exception( $msg );
    }

    /**
     * @brief   Concatène les variables passées en arguments la dernière servant de séparateur
     * @return  string
     */
    public static function implode() {
      $tb_base = array();
      $args = func_get_args();
      $tmp_args = array();
      foreach( $args AS $idx => $value )
        if ( is_array( $value ) ) $tmp_args = array_merge( $tmp_args, array_values( $value ) );
        else $tmp_args[] = $value;
      $n_args = count( $tmp_args );

      $rv = '';
      if ( $n_args > 1 ) {
        $sep = $tmp_args[ $n_args - 1 ];
        for( $i=0; $i<$n_args-1; $i++ )
          if ( '' != trim( $tmp_args[ $i ] ) )
            $tb_base[] = $tmp_args[ $i ];
        $rv = implode( $sep, $tb_base );
      }
      return $rv;
    }

    public static function find_class_filepath( &$classpath ) {
      if ( is_null( self::$_basedir ) )
        self::$_basedir = dirname( __FILE__ );
      $classpath = str_replace( '.', DIRECTORY_SEPARATOR, $classpath );
      if ( '*' != substr( $classpath, -1 ) )
        $classpath .= '.php';

      $include_dir = self::$_basedir;
      if ( __CLASS__ == substr( $classpath, 0, strlen( __CLASS__ ) ) )
        $include_dir = dirname( __FILE__ );

      $full_filepath = $include_dir.DIRECTORY_SEPARATOR.$classpath;
      return $full_filepath;
    }

    /**
    * @brief    Import un ensemble de fichiers
    * @param    $path   string    le chemin du namespace à importer
    * @param    $includeSubDirectory    boolean   indique si l'on souhaite inclure récursivement les sous dossiers
    * @return   boolean|void
    * @code
    *   System::import( 'System.Interfaces.*' ); // import tous les fichiers situés directement dans le répertoire System/Interfaces/
    * @endcode
    */
    public static function import( $path, $includeSubDirectory = false ) {
      if ( !function_exists( 'glob' ) )
        throw new Exception( 'glob function required to import namespace' );

      static $_included = array();
/*
      if ( is_null( self::$_basedir ) )
        self::$_basedir = dirname( __FILE__ );
      $path = str_replace( '.', DIRECTORY_SEPARATOR, $path );
      if ( '*' != substr( $path, -1 ) )
        $path .= '.php';

      $include_dir = self::$_basedir;
      if ( __CLASS__ == substr( $path, 0, strlen( __CLASS__ ) ) )
        $include_dir = dirname( __FILE__ );

      $fullpath = $include_dir.DIRECTORY_SEPARATOR.$path;
*/
      $path_pattern = self::find_class_filepath( $path );
      if ( in_array( $path_pattern, $_included ) )
        return true;

      $include = create_function(
        '$path',
        '$tmp = glob( $path, GLOB_NOSORT );
if ( count( $tmp ) > 0 ) {
  foreach( $tmp AS $filepath )
    if ( !is_dir( $filepath ) && \'php\' == substr( $filepath, -3 ) )
      require_once $filepath;
  return true;
} else {
  return false;
}'
      );

      if ( !$include( $path_pattern ) ) {
        $tmp = self::$_alternativeIncludeDir;
        while( $dir = array_shift( $tmp ) ) {
          if ( $include( $dir.$path ) )
            break;
        }
      }

      $_included[] = $path_pattern;
      if ( $includeSubDirectory ) {
        $tmp = glob( $path, GLOB_ONLYDIR );
        foreach( $tmp AS $directory )
          self::import( $directory.'.*', true );
      }
    }

    /**
    * @brief    Examine un objet
    * @param    $object Object  l'objet à examiner
    * @param    $title    string    un titre
    * @param    $return   boolean   si true alors les données seront juste retournées sinon elles seront aussi affichées
    * @return   string|void
    */
    public static function export( $object, $title = null, $return = false ) {
      $rv = '<pre>';
      if ( !is_null( $title ) )
        $rv .= '<span style="text-decoration: underline;">'.$title.' :</span>'.self::crlf;
      $rv .= stripslashes( var_export( $object, true ) );
      $rv .= self::crlf.'</pre>';
      if ( !$return )
        echo $rv;
      return $rv;
    }

    /**
    * @brief  Examine un objet
    * @param  $object Object  l'objet à examiner
    * @param  $title    string    un titre
    * @return void
    */
    public static function dump( $object, $title = null ) {
      if ( !is_a( $object, 'iIterable' ) ) {
        self::export( $object, $title );
        return ;
      }
      echo '<pre>';
      if ( !is_null( $title ) )
        echo '<span style="text-decoration: underline;">', $title, ' :</span>', self::crlf;
      $iterator = $object->getIterator();
      while( $iterator->hasNext() ) {
        echo $iterator->key(), ' > ';
        echo $iterator->current();
        echo self::crlf;
        $iterator->moveNext();
      }
      echo '</pre>';
    }
  }
?>
