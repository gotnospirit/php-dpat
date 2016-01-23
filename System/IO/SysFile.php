<?php
  /**
   * @package     	IO
   * @class       	SysFile
   * @author      	Jimmy CHARLEBOIS
   * @date        	24-01-2007
   * @brief       	Manipulation de fichier
   */
  System::import( 'System.Interfaces.IResource' );
  System::import( 'System.Exceptions.IOException' );

  class SysFile implements IResource {
    private $_filename;
    private $_path;
    private $_extension;

    protected $_filepath;
    protected $_resource;

    /** @defgroup   FileAccessType   Constantes pour définir le type d'accès au log */
    /*@{*/
    /** @brief  Accès en écriture seule (mode écrasement) */
    const WRITE_ACCESS    = 1;
    /** @brief  Accès en lecture seule */
    const READ_ACCESS     = 2;
    /** @brief  Accès en écriture seule (mode ajout) */
    const APPEND_ACCESS   = 4;
    /** @brief  Permet l'écriture de données binaires */
    const BINARY_ACCESS   = 8;
    /*@}*/

    public function __construct( $filepath ) {
      $this->_filepath = $filepath;
      $info = @pathinfo( $filepath );
      if ( false !== $info && is_array( $info ) ) {
        $this->_filename = $info[ 'basename' ];
        $this->_path = $info[ 'dirname' ];
        $this->_extension = ( array_key_exists( 'extension', $info ) )
          ? $info[ 'extension' ] : null;
      }
      $this->_resource = null;
    }

    /**
     * @brief   Ouvre le fichier
     * @param   $access_type    const   Type d'accès pour l'ouverture \ref FileAccessType
     * @return  void
     * @throw   IOException
     */
    public function open( $access_type ) {
      if ( !is_null( $this->_resource ) )
        throw new IOException( 'File already opened' );

      $access = '';
      if ( self::WRITE_ACCESS & $access_type )
        $access = 'w';
      elseif ( self::READ_ACCESS & $access_type )
        $access = 'r';
      elseif ( self::APPEND_ACCESS & $access_type )
        $access = 'a';

      if ( self::BINARY_ACCESS & $access_type )
        $access .= 'b';
      $this->_resource = @fopen( $this->_filepath, $access );
      if ( false === $this->_resource )
        $this->_resource = null;
    }

    /**
     * @brief   Ferme le fichier
     * @return  void
     * @throw   IOException
     */
    public function close() {
      if ( is_null( $this->_resource ) )
        throw new IOException( 'File not opened' );
      @fclose( $this->_resource );
      $this->_resource = null;
    }

    /**
     * @brief   Écrit des données dans le fichier
     * @param   $data   mixed   les données à écrire
     * @return  boolean
     * @throw   IOException
     */
    public function write( $data ) {
      if ( is_null( $this->_resource ) )
        throw new IOException( 'File not opened' );
      return ( false != @fwrite( $this->_resource, $data ) );
    }

    /**
     * @brief   Lit des données depuis le fichier
     * @return  string
     * @throw   IOException
     */
    public function readLine() {
      if ( is_null( $this->_resource ) )
        throw new IOException( 'File not opened' );
      return @fgets( $this->_resource );
    }

    /** @brief    Implémentation de l'interface IResource */
    /*@{*/
    public function dispose() {
      $this->close();
    }
    /*@}*/

    /**
     * @see   getFilepath
     */
    public function __toString() {
      return $this->getFilepath();
    }

    /**
     * @brief   Retourne le chemin complet du fichier
     * @return  string
     */
    public function getFilepath() {
      return $this->_path.DIRECTORY_SEPARATOR.$this->_filename;
    }

    /**
     * @brief   Retourne l'extension du fichier
     * @return  string
     */
    public function getExtension() {
      return $this->_extension;
    }

    /**
     * @brief   Retourne le nom du répertoire auquel appartient le fichier
     * @return  string
     */
    public function getDirectoryName() {
      return $this->_path;
    }

    /**
     * @brief   Retourne le nom du fichier
     * @return  string
     */
    public function getFilename() {
      return $this->_filename;
    }

    /**
     * @brief   Retourne le contenu d'un fichier
     * @param   $filepath   string    le chemin du fichier
     * @return  string|false
     */
    public static function getContent( $filepath ) {
      return @file_get_contents( $filepath );
    }

    /**
     * @brief   Indique si un fichier existe
     * @param   $filepath   string    le chemin du fichier
     * @return  boolean
     */
    public static function exists( $filepath ) {
      return @file_exists( $filepath );
    }

    /**
     * @brief   Retourne un tableau d'information sur un fichier
     * @param   $filepath   string    le chemin du fichier
     * @return  array|false
     */
    public static function getInfo( $filepath ) {
      return @pathinfo( $filepath );
    }
  }
?>