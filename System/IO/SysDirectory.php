<?php
  /**
   * @package     	IO
   * Ce package dispose des classes permettant de g�rer les entr�es/sorties sur le syst�me de fichier du serveur
   * 
   * @class       	SysDirectory
   * @author      	Jimmy CHARLEBOIS
   * @date        	24-01-2007
   * @brief       	Manipulation de r�pertoire
   */
  System::import( 'System.ADT.Queue' );

  class SysDirectory {
    private $_name;
    private $_path;

    public function __construct( $path ) {
      $this->_path = $path;
      $this->_name = null;

      $info = @pathinfo( $path );
      if ( $info !== false ) {
        $this->_name = $info[ 'basename' ];
      }
    }

    /**
     * @see   getPath
     */
    public function __toString() {
      return $this->getPath();
    }

    /**
     * @brief   Retourne le nom du r�pertoire
     * @return  string
     */
    public function getName() {
      return $this->_name;
    }

    /**
     * @brief   Retourne le chemin du r�pertoire
     * @return  string
     */
    public function getPath() {
      return $this->_path;
    }

    /**
     * @brief   Indique si un r�pertoire existe
     * @param   $dirname    string    le chemin du r�pertoire
     * @return  boolean
     */
    public static function exists( $dirname ) {
      return ( @file_exists( $dirname ) && @is_dir( $dirname )  );
    }

    /**
     * @brief   Retourne une collection des r�pertoires pr�sents dans le r�pertoire
     * @param   $dirname    string    nom du r�pertoire � explorer
     * @return  Queue( SysDirectory[] )
     * @throw   Exception
     * @code
     *   $dirs = SysDirectory::getDirectories( '/var' );
     *    $iterator =& $sub_dirs->getIterator();
     *    while( $iterator->hasNext() ) {
     *      $entry =& $iterator->next();
     *      System::export( (string)$entry );
     *    }
     * @endcode
     */
    public static function getDirectories( $dirname ) {
      $rv =& new Queue();

      if ( DIRECTORY_SEPARATOR != substr( $dirname, -1 ) )
        $dirname .= DIRECTORY_SEPARATOR;

      if ( !self::exists( $dirname ) )
        throw new Exception( 'Unknown directory' );

      $fp = @opendir( $dirname );
      while ( $dir = @readdir( $fp ) ) {
        if ( is_dir( $dirname.$dir ) )
          $rv->enqueue( new SysDirectory( $dirname.$dir ) );
      }
      @closedir( $fp );
      return $rv;
    }

    /**
     * @brief   Retourne une collection des fichiers pr�sents dans le r�pertoire
     * @param   $dirname    string    nom du r�pertoire � explorer
     * @return  Queue( SysFile[] )
     * @throw   Exception
     * @code
     *   $files = SysDirectory::getFiles( '/var/www' );
     *   echo "Liste des fichiers\n";
     *   foreach( $files AS $idx => $file )
     *    if ( 'php' == $file->getExtension() )
     *      echo $file."\n";
     * @endcode
     */
    public static function getFiles( $dirname ) {
      System::import( 'System.IO.SysFile' );

      $rv =& new Queue();

      if ( DIRECTORY_SEPARATOR != substr( $dirname, -1 ) )
        $dirname .= DIRECTORY_SEPARATOR;

      if ( !self::exists( $dirname ) )
        throw new Exception( 'Unknown directory' );

      $fp = @opendir( $dirname );
      while ( $file = @readdir( $fp ) ) {
        if ( !is_dir( $dirname.$file ) )
          $rv->enqueue( new SysFile( $dirname.$file ) );
      }
      @closedir( $fp );
      return $rv;
    }

    /**
     * @brief   Cr�e un r�pertoire
     * param    $dirname    string    le nom du r�pertoire � cr�er
     * @return  boolean
     */
    public static function create( $dirname ) {
      return ( !@file_exists( $dirname ) )
        ? @mkdir( $dirname ) : true;
    }

    /**
     * @brief   Cr�er une arborescence compl�te de r�pertoire
     * param    $fullPath     string    cha�ne repr�sentant l'arborescence � cr�er
     * param    $separator    string    s�parateur permettant de s�parer les r�pertoires � cr�er
     * @return  boolean
     * @code
     *  SysDirectory::createPath( 'machin/truc/chouette' );
     * @endcode
    */
    function createPath( $fullPath, $separator = DIRECTORY_SEPARATOR ) {
      $tmp = explode( $separator, str_replace( $separator.$separator, $separator, $fullPath ) );
      $max = count( $tmp );
      $postDirectories = '';
      $rv = true;
      for( $i=0; $i<$max; $i++ ) {
        $len = strlen( $tmp[ $i ] );
        if ( 0 != $i && 0 == $len )
          break;
        if ( 0 != $len )
          if ( !self::create( $postDirectories.$tmp[ $i ] ) ) {
            $rv = false;
            break;
          }
        $postDirectories .= $tmp[ $i ].$separator;
      }
      return $rv;
    }
  }
?>