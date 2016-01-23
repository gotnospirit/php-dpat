<?php
  /**
   * @package     	Caddy.Storage
   * @class       	CaddyStorage
   * @author      	Jimmy CHARLEBOIS
   * @date        	
   * @brief       	
   */
  System::import( 'System.Interfaces.Caddy.ICaddyStorage' );
  System::import( 'System.Event.EventListener' );

  abstract class CaddyStorage extends EventListener implements ICaddyStorage {
    protected $_storage;

    protected $_caddy;
    protected $_caddy_id;
    protected $_date_creation;
    protected $_date_update;

    public function __construct( IDataSource &$ds, ICaddy &$caddy = null ) {
      parent::__construct( $ds );
      $ds->addEventListener( $this );

      $this->_storage =& $ds;

      $this->_caddy =& $caddy;
      $this->_caddy_id = null;
      $this->_date_creation = null;
      $this->_date_update = null;
    }

    /**
     * @brief   Définit le caddy sur lequel on va opérer
     * @param   $caddy    ICaddy
     * @return  void
     */
/*
    public function setCaddy( ICaddy &$caddy ) {
      $this->_caddy =& $caddy;
    }
*/

    /**
     * @brief   Retourne l'identifiant du caddy
     * @return  integer
     */
    public function &getCaddyId() {
      return $this->_caddy_id;
    }

    /**
     * @brief   Retourne la date de création de la sauvegarde
     * @return  string
     */
    public function getDateCreation() {
      return $this->_date_creation;
    }

    /**
     * @brief   Retourne la date de dernière mise à jour de la sauvegarde
     * @return  string
     */
    public function getDateUpdate() {
      return $this->_date_update;
    }

    abstract public function onStorageError( IEvent &$oEvent, $args = null );
  }
?>