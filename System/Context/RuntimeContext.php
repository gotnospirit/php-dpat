<?php
  /**
   * @package   	Context
   * @class   		RuntimeContext
   * @author        Jimmy CHARLEBOIS
   * @date          04-12-2006
   * @brief         Décoration de contexte pour contexte d'exécution
   */
  System::import( 'System.Interfaces.Context.IContext' );

  class RuntimeContext implements IContext {
    private $_context;
    private $_runtime_vars;

    public function __construct( IContext $context ) {
      $this->_context =& $context;
      $this->_runtime_vars = array();
    }

    public function __call( $methodName, $args ) {
      if ( is_callable( array( $this->_context, $methodName ) ) )
        return call_user_func_array( array( $this->_context, $methodName ), $args );
    }

    public function &getParams() {
      return $this->_context->getParams();
    }
    public function hasParam( $key ) {
      return $this->_context->hasParam( $key );
    }
    public function &getParam( $key ) {
      return $this->_context->getParam( $key );
    }

    /**
     * @brief   Retourne la valeur d'une variable utilisateur
     * @param   $key    strint    nom de la variable
     * @return  mixed
     */
    public function &get( $key ) {
      return $this->_runtime_vars[ $key ];
    }

    /**
     * @brief   Définit une variable utilisateur
     * @param   $key    string    nom de la variable
     * @param   $value  mixed     valeur de la variable
     * @return  void
     */
    public function set( $key, &$value ) {
      $this->_runtime_vars[ $key ] =& $value;
    }
  }
?>