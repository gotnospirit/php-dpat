<?php
  /**
   * @package     Context
   * @class       Context
   * @author      Jimmy CHARLEBOIS
   * @date        16-11-2006
   * @brief       Super-classe pour contexte d'ex�cution
   * @see         HttpContext, ShellContext
   */
  System::import( 'System.Interfaces.Context.IContext' );

  abstract class Context implements IContext {
    /** @brief    array   Collection des param�tres d�finis dans le contexte */
    private $_params;

    protected function __construct() {
      $this->_params = array();
    }

    /**
     * @brief   Retourne une collection des param�tres du contexte
     * @return  Hashtable
     */
    public function &getParams() {
      System::import( 'System.ADT.Hashtable' );
      $rv =& new Hashtable();
      foreach( $this->_params AS $key => $value )
        $rv->put( $key, $this->_params[ $key ] );
      return $rv;
    }

    /**
     * @brief   Indique si le param�tre existe dans le contexte
     * @param   $key    string    nom du param�tre
     * @return  boolean
     */
    public function hasParam( $key ) {
      return array_key_exists( $key, $this->_params );
    }

    /**
     * @brief   Retourne la valeur d'un param�tre du contexte
     * @param   $key    string    nom du param�tre
     * @return  mixed
     */
    public function &getParam( $key ) {
      $rv = null;
      if ( array_key_exists( $key, $this->_params ) )
        $rv =& $this->_params[ $key ];
      return $rv;
    }

    /**
     * @brief   D�finit un param�tre dans le contexte
     * @param   $key    string    nom du param�tre
     * @param   $value  mixed     valeur du param�tre
     * @return  void
     */
    protected function setParam( $key, $value ) {
      $this->_params[ $key ] =& $value;
    }

    /**
     * @brief   Supprime les espaces en d�but et fin de cha�ne ou retourne null si la cha�ne est vide
     * @param   $txtString    string    la cha�ne � nettoyer
     * @return  string|null
     */
    protected function cleanString( $txtString ) {
      $txtString = trim( $txtString );
      return ( strlen( $txtString ) > 0 )
        ? stripslashes( $txtString ) : null;
    }

    /**
     * @brief   Applique la m�thode cleanString � un tableau
     * @param   $array    array   Collection � nettoyer
     * @return  array
     */
    protected function cleanArray( $array ) {
      if ( !is_array( $array ) ) return $this->cleanString( $array );
      $rv = array();
      foreach( $array AS $key => $value )
        $rv[ $key ] = ( is_array( $value ) )
          ? $this->cleanArray( $value )
          : $this->cleanString( $value );
      return $rv;
    }
  }
?>