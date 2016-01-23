<?php
  /**
   * @package       Dbms
   * @class         DbmsResultSet
   * @author        Jimmy CHARLEBOIS
   * @date          02-01-2007
   * @brief         Classe abstraite pour jeu de r�sultats de Dbms
   */
  System::import( 'System.Interfaces.DataSource.IResultSet' );
  System::import( 'System.Interfaces.Iteration.IIterator' );

  abstract class DbmsResultSet implements IResultSet, IIterator {
    private $_resource; 
    private $_pointeur;
    private $_size;

    public function __construct( &$res ) {
      $this->_resource =& $res;
      $this->_pointeur = -1;
      $this->_size = 0;
    }

    /**
     * @brief   D�finit la taille du jeu de r�sultat
     * @param   $count    integer   la taille du jeu de r�sultat
     * @return  void
     */
    protected function setSize( $count ) {
      if ( is_int( $count ) )
        $this->_size = $count;
    }

    /**
     * @brief   Retourne la taille du jeu de r�sultat
     * @return  integer
     */
    public function size() {
      return $this->_size;
    }

    /**
     * @brief   D�finit la nouvelle position du curseur interne
     * @param   $pos    integer   la nouvelle position
     * @return  void
     */
    protected function setPosition( $pos ) {
      $this->_pointeur = $pos;
    }

    /**
     * @brief   Retourne la position du curseur interne
     * @return  integer
     */
    protected function getPosition() {
      return $this->_pointeur;
    }

    public function hasNext() {
      return ( $this->_pointeur + 1 < $this->_size );
    }

    public function key() {
      return $this->_pointeur;
    }

    /**
     * @brief   Retourne la ressource php associ�e au jeu de r�sultat
     * @return  resource
     */
    protected function &getResource() {
      return $this->_resource;
    }
  }
?>