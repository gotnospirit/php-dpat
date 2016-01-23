<?php
  /**
   * @package     	Ini
   * @class       	IniSection
   * @author      	Jimmy CHARLEBOIS
   * @date        	06-12-2006
   * @brief       	Repr�sentation d'une section d'un fichier ini
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
     * @brief   Indique si une variable est d�finie dans la section
     * @param   $key      string    le nom de la cl�
     * @return  boolean
     */
    public function hasVar( $key ) {
      return array_key_exists( $key, $this->_vars );
    }

    /**
     * @brief   Ajoute une variable � la section
     * @param   $key      string    le nom de la cl�
     * @param   $value    mixed     la valeur associ�e � la cl�
     * @return  void
     */
    public function addVar( $key, $value ) {
      $this->_vars[ $key ] =& $value;
    }

    /**
     * @brief   Retourne la valeur d'une cl� de la section
     * @param   $key      string    le nom de la cl�
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