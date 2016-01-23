<?php
  /**
   * @package     Context
   * @class       Context
   * @author      Jimmy CHARLEBOIS
   * @date        16-11-2006
   * @brief       Super-classe pour contexte d'exécution
   * @see         HttpContext, ShellContext
   */
  System::import( 'System.Interfaces.Context.IContext' );

  abstract class Context implements IContext {
    /** @brief    array   Collection des paramètres définis dans le contexte */
    private $_params;

    protected function __construct() {
      $this->_params = array();
    }

    /**
     * @brief   Retourne une collection des paramètres du contexte
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
     * @brief   Indique si le paramètre existe dans le contexte
     * @param   $key    string    nom du paramètre
     * @return  boolean
     */
    public function hasParam( $key ) {
      return array_key_exists( $key, $this->_params );
    }

    /**
     * @brief   Retourne la valeur d'un paramètre du contexte
     * @param   $key    string    nom du paramètre
     * @return  mixed
     */
    public function &getParam( $key ) {
      $rv = null;
      if ( array_key_exists( $key, $this->_params ) )
        $rv =& $this->_params[ $key ];
      return $rv;
    }

    /**
     * @brief   Définit un paramètre dans le contexte
     * @param   $key    string    nom du paramètre
     * @param   $value  mixed     valeur du paramètre
     * @return  void
     */
    protected function setParam( $key, $value ) {
      $this->_params[ $key ] =& $value;
    }

    /**
     * @brief   Supprime les espaces en début et fin de chaîne ou retourne null si la chaîne est vide
     * @param   $txtString    string    la chaîne à nettoyer
     * @return  string|null
     */
    protected function cleanString( $txtString ) {
      $txtString = trim( $txtString );
      return ( strlen( $txtString ) > 0 )
        ? stripslashes( $txtString ) : null;
    }

    /**
     * @brief   Applique la méthode cleanString à un tableau
     * @param   $array    array   Collection à nettoyer
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