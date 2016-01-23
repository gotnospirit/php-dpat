<?php
  /**
   * @package     	Calendar
   * @class       	StandardCalendarController
   * @author      	Jimmy CHARLEBOIS
   * @date        	04-01-2007
   * @brief       	Contrôleur standard de calendrier
   */
  System::import( 'System.MVC.AbstractController' );

  class StandardCalendarController extends AbstractController {
    private $_context;
    private $_mode;
    private $_range;

    /**
     * @defgroup CalendarMode  Constantes pour modifier le mode d'affichage du calendrier
     */
    /*@{*/
    const   MODE_READ   = 'Read';
    const   MODE_EDIT   = 'Edit';
    /*@}*/

    /**
     * @defgroup CalendarRange  Constantes pour modifier le type de vue du calendrier
     */
    /*@{*/
    const   VIEW_ANNUAL   = 'annual';
    const   VIEW_DAILY    = 'daily';
    /*@}*/

    public function __construct( IContext &$context, CalendarModel &$model ) {
      parent::__construct( $model );
      $this->_context =& $context;
      $this->_mode = $context->getParam( 'mode' );
      if ( is_null( $this->_mode ) )
        $this->_mode = self::MODE_READ;
      $this->_range = $context->getParam( 'range' );
      if ( is_null( $this->_range ) )
        $this->_range = self::VIEW_ANNUAL;

      $model->setController( $this );
    }

    public function &getContext() { return $this->_context; }

    /**
     * @brief   Retourne le mode actuellement utilisé
     * @return  const \ref CalendarMode
     */
    public function getMode() {
      return $this->_mode;
    }

    /**
     * @brief   Retourne le type de vue actuellement utilisé
     * @return  const \ref CalendarRange
     */
    public function getRange() {
      return $this->_range;
    }

    /**
     * @brief   Retourne une url permettant de changer le mode du calendrier
     * @param   $newMode    const               le nouveau mode \ref CalendarMode
     * @param   $type       const               type de vue \ref CalendarRange
     * @param   $date       CalendarDateModel   la date pour laquelle on change de mode
     * @return  string
     */
    private function getModeUrl( $newMode, $type, CalendarDateModel &$date = null ) {
      $rv = $this->getContext()->getParam( 'PHP_SELF' ).'?mode='.urlencode( $newMode );
      if ( !is_null( $date ) )
        $rv .= '&date='.urlencode( $date->toDate() );
      return $rv;
    }

    /**
     * @brief   Retourne une url pour une vue journalière
     * @param   $date   CalendarDateModel   la date pour laquelle on va passer en mode journalier
     * @param   $mode   const               \ref CalendarMode
     * @return  string
     * @see     getModeUrl
     */
    public function getDailyUrl( CalendarDateModel &$date, $mode = self::MODE_READ ) {
      return $this->getModeUrl( $mode, self::VIEW_DAILY, $date );
    }

    public function process() {
      $model =& $this->getModel();

      $viewClassname = 'AnnualCalendar'.$this->_mode.'View';
      $selected_date = $this->getContext()->getParam( 'date' );
      if ( !is_null( $selected_date ) ) {
        $viewClassname = 'DailyCalendar'.$this->_mode.'View';
        $model->setCurrentDate( $selected_date );
      }
      $model->init();

      System::import( 'System.Calendar.Views.'.$this->_mode.'.'.$viewClassname );

      $view =& new $viewClassname();
      $view->setModel( $model );
      $this->setView( $view );
    }
  }
?>