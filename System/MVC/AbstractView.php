<?php
  /**
   * @package     	MVC
   * @class       	AbstractView
   * @author      	Jimmy CHARLEBOIS
   * @date        	04-01-2007
   * @brief       	Classe abstraite pour implémenter les vues
   */
  System::import( 'System.Interfaces.MVC.IView' );

  abstract class AbstractView implements IView {
    private $_model;
    private $_controller;

    public function __construct() {
      $this->_model = null;
      $this->_controller = null;
    }

    public function &getModel() {
      return $this->_model;
    }

    public function setModel( IModel &$model ) {
      $this->_model =& $model;
    }

    public function &getController() {
      return $this->_controller;
    }

    public function setController( IController &$controller ) {
      $this->_controller =& $controller;
    }

    public function display() {
      echo $this->render();
    }
  }
?>