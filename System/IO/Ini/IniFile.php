<?php
  /**
   * @package     	Ini
   * @class       	IniFile
   * @author      	Jimmy CHARLEBOIS
   * @date        	06-12-2006
   * @brief       	Représentation d'un fichier ini
   */
  System::import( 'System.IO.Ini.IniSection' );
//  require_once 'IniSection.php';

  class IniFile {
    /** @brief    array   Collection des sections du fichier */
    private $_sections;

    const crlf = PHP_EOL;   //  "\r\n";

    public function __construct() {
      $this->_sections = array();
    }

    /**
     * @brief   Indique si des sections ont été définies ou si une précise existe
     * @param   $sectionTitle   string    le titre d'une section
     * @return  boolean
     */
    public function hasSection( $sectionTitle = null ) {
      if ( is_null( $sectionTitle ) )
        return count( $this->_sections );
      else {
        $rv = false;
        foreach( $this->_sections AS $idx => &$section )
          if ( $section->getTitle() == $sectionTitle ) {
            $rv = true;
            break;
          }
        return $rv;
      }
    }

    /**
     * @brief   Retourne une section
     * @param   $sectionTitle   string    le titre de la section à récupérer
     * @return  IniSection|null
     */
    public function &getSection( $sectionTitle ) {
      $rv = null;
      foreach( $this->_sections AS $idx => &$section )
        if ( $section->getTitle() == $sectionTitle ) {
          $rv =& $section;
          break;
        }
      return $rv;
    }

    /**
     * @brief   Créer une section et la retourne
     * @param   $title    string    le titre de la section
     * @return  IniSection
     */
    public function &createSection( $title ) {
      $rv =& new IniSection( $title );
      $this->_sections[] =& $rv;
      return $rv;
    }

    /**
     * @brief   Retourne le contenu du fichier ini
     * @return  string
     */
    public function toString() {
      $rv = '';
      foreach( $this->_sections AS $idx => &$section )
        $rv .= $section->toString().self::crlf;
      return $rv;
    }

    /**
     * @brief   Charge les données d'un fichier .ini
     * @param   $filepath   string    le chemin du fichier à charger
     * @return  IniFile
     * @throw   Exception
     */
    public static function &load( $filepath ) {
      $rv =& new IniFile();
      $ini_sections = @parse_ini_file( $filepath, true );
      if ( $ini_sections === false )
        throw new Exception( 'Cannot parse `'.$filepath.'` !' );
      elseif ( 0 == count( $ini_sections ) )
        throw new Exception( 'No data' );

      foreach( $ini_sections AS $sectionName => $keys ) {
        $section =& $rv->createSection( $sectionName );
        foreach( $keys AS $key => $value )
          $section->addVar( $key, trim( $value ) );
      }
      return $rv;
    }
/*
    public static function &load( $filepath ) {
      $filecontent = @file( $filepath );
      if ( $filecontent === false )
        throw new Exception( 'Cannot open `'.$filepath.'` !');
      // on supprime toutes les lignes de commentaire ( commençant par # ou ; )
      foreach( $filecontent AS $idx => $line )
        if ( '#' == $line{ 0 } || ';' == $line{ 0 } )
          unset( $filecontent[ $idx ] );
      $filecontent = implode( $filecontent, '' );
      $rv =& new IniFile();
      $matches = array();
      preg_match_all( '~\[(.[^\]]*)\](.[^\[]*)~im', $filecontent, $matches );
      if ( count( $matches[ 0 ] ) > 0 ) {
        foreach( $matches[ 1 ] AS $idx => $key ) {
          $section =& $rv->createSection( $key );
          $keyConfig = trim( $matches[ 2 ][ $idx ] );

          $match = array();
          preg_match_all( '~(.[^;=]*)=(.*)~', $keyConfig, $match );
          if ( count( $match[ 0 ] ) > 0 ) {
            foreach( $match[ 1 ] AS $idx => $value ) {
              $value = trim( $value );
              if ( strlen( trim( $match[ 2 ][ $idx ] ) ) > 0 )
                $section->addVar( $value, trim( $match[ 2 ][ $idx ] ) );
            }
          }
        }
      }
      return $rv;
    }
*/
    /**
     * @brief   Retourne une collection représentant le contenu d'un fichier d'initialisation
     * @param   $filecontent    string    le contenu du fichier d'initialisation
     * @return  array
     */
    public static function toArray( $filecontent ) {
      $rv = null;
      $matches = array();
      preg_match_all( '~\[(.[^\]]*)\](.[^\[]*)~im', $filecontent, $matches );
      if ( count( $matches[ 0 ] ) > 0 ) {
        $rv = array();
        foreach( $matches[ 1 ] AS $idx => $key ) {
          $keyConfig = trim( $matches[ 2 ][ $idx ] );

          $tmp = array();
          preg_match_all( '~(.[^=]*)=(.*)~', $keyConfig, $tmp );
          if ( count( $tmp[ 0 ] ) > 0 ) {
            foreach( $tmp[ 1 ] AS $idx => $value )
              if ( '#' != $value{ 0 } && ';' != $value{ 0 } ) // # ou ; en début de ligne >> commentaire
                $rv[ $key.'.'.$value ] = ( strlen( trim( $tmp[ 2 ][ $idx ] ) ) > 0 )
                  ? trim( $tmp[ 2 ][ $idx ] ) : null;
          }
        }
      }
      return $rv;
    }
  }
?>