<?php
  /**
   * @package     	Ini
   * @class       	IniSection
   * @author      	Jimmy CHARLEBOIS
   * @date        	06-12-2006
   * @brief       	Représentation d'une section d'un fichier ini
   */

  class IniSection {
    /** @brief    string    Le titre de la section */
    private $_title;
    /** @brief    array     Collection des variables de la section */
    private $_vars;

    function __construct( $title ) {
      $this->_title = $title;
      $this->_vars = array();
    }

    /**
     * @brief   Retourne le titre de la section
     * @return  string
     */
    public function getTitle() {
      return $this->_title;
    }

    /**
     * @brief   Indique si une variable est définie dans la section
     * @param   $key      string    le nom de la clé
     * @return  boolean
     */
    public function hasVar( $key ) {
      return array_key_exists( $key, $this->_vars );
    }

    /**
     * @brief   Ajoute une variable à la section
     * @param   $key      string    le nom de la clé
     * @param   $value    mixed     la valeur associée à la clé
     * @return  void
     */
    public function addVar( $key, $value ) {
      $this->_vars[ $key ] =& $value;
    }

    /**
     * @brief   Retourne la valeur d'une clé de la section
     * @param   $key      string    le nom de la clé
     * @return  mixed
     */
    public function &getVar( $key ) {
      $rv = null;
      if ( array_key_exists( $key, $this->_vars ) )
        $rv =& $this->_vars[ $key ];
      return $rv;
    }

    /**
     * @brief  Retourne le contenu de la section
     * @return string
     */
    public function toString() {
      $rv = '['.$this->_title.']'.Ini::crlf;
      foreach( $this->_vars AS $key => $value )
        $rv .= sprintf( '%s=%s', $key, $value ).Ini::crlf;
      return $rv;
    }
  }
?>