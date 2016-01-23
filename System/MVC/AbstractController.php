<?php
  /**
   * @package     	MVC
   * @class       	AbstractController
   * @author      	Jimmy CHARLEBOIS
   * @date        	04-01-2007
   * @brief       	Classe abstraite pour implémenter les contrôleurs
   */
  System::import( 'System.Interfaces.MVC.IController' );

  abstract class AbstractController implements IController {
    private $_model;
    private $_view;

    public function __construct( IModel &$model ) {
      $this->_model = $model;
      $this->_view = null;
    }

    public function &getModel() {
      return $this->_model;
    }
    public function setModel( IModel &$model ) {
      $this->_model =& $model;
    }

    public function &getView() {
      return $this->_view;
    }
    public function setView( IView &$view ) {
      $this->_view =& $view;
    }
  }
?>