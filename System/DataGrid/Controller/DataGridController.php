<?php
  /**
   * @package     DataGrid
   * @class       DataGridController
   * @author      Jimmy CHARLEBOIS
   * @date        16-11-2006
   * @brief       Controlleur basique pour DataGrid
   */
  System::import( 'System.MVC.AbstractController' );
  System::import( 'System.DataGrid.View.Read.DataGridReadView' );
  System::import( 'System.DataGrid.View.Edit.DataGridEditView' );

  class DataGridController extends AbstractController {
    private $_context;

    public function __construct( IContext &$context, DataGrid &$model ) {
      parent::__construct( $model );

      $this->_context =& $context;
    }

    public function &getContext() { return $this->_context; }

    public function process() {
      $id = $this->_context->getParam( 'datagrid-id' );
      $mode = $this->_context->getParam( 'datagrid-mode' );

      /**
       * @todo  Réfléchir à l'opportunité d'implémenter État pour gérer ces if
       */
      if ( is_null( $mode ) || 'read' == $mode || $id != $this->getModel()->getId() ) {
        $this->setView( new DataGridReadView( $this->getModel() ) );
      } else {
        if ( 'processInput' == $mode ) {
          System::export( $this->_context );
        }
        $view = new DataGridEditView( $this->getModel() );
        $view->setController( $this );
        $this->setView( $view );
      }
    }
  }
?>