<?php
  /**
   * @class       	SessionContext
   * @author      	Jimmy CHARLEBOIS
   * @date        	11-04-2007
   * @brief       	Contexte pour intéraction avec la session du visiteur
   */

  class SessionContext {
    private $_sessionUID;
    private $_sessionClassname;

    public function __construct( $className = null ) {
      if ( is_null( $className ) )
        $className = 'Session';
      $this->_sessionClassname = $className;
      $this->_sessionUID = $this->callSessionMethod( 'getUID' );
    }

    private function &callSessionMethod( $methodName, $args = array() ) {
      $rv =& call_user_func_array( array( $this->_sessionClassname, $methodName ), $args );
      return $rv;
    }

    public function getUID() {
      return $this->_sessionUID;
    }

    /**
     * @brief   Définit une variable dans la session de l'utilisateur
     * @param   $key    string    le nom de la variable
     * @param   $value  mixed     la valeur de cette variable
     * @return  void;
     */
    public function set( $key, $value ) {
      $_sess =& $this->callSessionMethod( 'get', array( $this->_sessionUID ) );
      if ( is_null( $_sess ) )
        $_sess = array();

      $_sess[ $key ] = $value;
      $this->callSessionMethod( 'set', array( $this->_sessionUID, $_sess ) );
    }

    /**
     * @brief   Détruit une variable de la session ou toute la session
     * @param   $key    string    le nom de la variable
     * @return  void;
     */
    public function delete( $key = null ) {
      if ( is_null( $key ) )
        $this->callSessionMethod( 'delete', array( $this->_sessionUID ) );
      else {
        $_sess =& $this->callSessionMethod( 'get', array( $this->_sessionUID ) );
        if ( !is_null( $_sess ) ) {
          if ( array_key_exists( $key, $_sess ) )
            unset( $_sess[ $key ] );
          $this->callSessionMethod( 'set', array( $this->_sessionUID, $_sess ) );
        }
      }
    }

    /**
     * @brief   Retourne une variable de la session de l'utilisateur
     * @param   $key    string    le nom de la variable
     * @return  mixed;
     */
    public function &get( $key ) {
      $_sess =& $this->callSessionMethod( 'get', array( $this->_sessionUID ) );
      $rv = null;
      if ( is_array( $_sess ) && isset( $_sess[ $key ] ) )
        $rv =& $_sess[ $key ];
      return $rv;
    }
  }
?>