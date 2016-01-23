<?php
  /**
   * @package     	Calendar
   * @class       	CalendarModel
   * @author      	Jimmy CHARLEBOIS
   * @date        	04-01-2007
   * @brief       	Modèle pour calendrier
   */
  System::import( 'System.Interfaces.MVC.IModel' );
  System::import( 'System.Calendar.Models.CalendarDateModel' );

  class CalendarModel implements IModel {
    private $_current_date;
    private $_bounds;

    private $_months;
    private $_days;

    private $_controller;

    const   CALENDAR_WEEK_NB_DAYS    = 7;

    public function __construct( $current_date ) {
      $this->_current_date =& new CalendarDateModel( $this, $current_date );
      $this->_bounds = array();
      $this->_months = array(
        1 => 'Jan',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Apr',
        5 => 'May',
        6 => 'Jun',
        7 => 'Jul',
        8 => 'Aug',
        9 => 'Sep',
        10 => 'Oct',
        11 => 'Nov',
        12 => 'Dec'
      );
      $this->_days = array(
        0 => 'S',
        1 => 'M',
        2 => 'T',
        3 => 'W',
        4 => 'T',
        5 => 'F',
        6 => 'S'
      );
      $this->_controller = null;
    }

    /**
     * @brief   Définit le contrôleur qui gère le modèle
     * @param   $ctrl   IController   le contrôleur à associer
     * @return  void
     */
    public function setController( IController &$ctrl ) {
      $this->_controller =& $ctrl;
    }

    /**
     * @brief   Retourne le contrôleur associé au modèle
     * @return  IController
     */
    public function &getController() {
      return $this->_controller;
    }

    /**
     * @brief   Définit les libellés des jours du calendrier
     * @param   $labels   array   Collection des libellés (clé: numéro - valeur: libellé)
     * @return  void
     * @throw   Exception
     */
    public function setDayLabels( $labels ) {
      if ( !is_array( $labels ) || 7 != count( $labels ) )
        throw new Exception( 'Please provide all labels !' );
      $this->_days = $labels;
    }

    /**
     * @brief   Retourne une collection des libellés des mois du calendrier
     * @return  array
     */
    public function getDayLabels() {
      return $this->_days;
    }

    /**
     * @brief   Définit les libellés des mois du calendrier
     * @param   $labels   array   Collection des libellés (clé: numéro - valeur: libellé)
     * @return  void
     * @throw   Exception
     */
    public function setMonthLabels( $labels ) {
      if ( !is_array( $labels ) || 12 != count( $labels ) )
        throw new Exception( 'Please provide all labels !' );
      $this->_months = $labels;
    }

    /**
     * @brief   Retourne une collection des libellés des mois du calendrier
     * @return  array
     */
    public function getMonthLabels() {
      return $this->_months;
    }

    /**
     * @brief   Définit la date courante du calendrier
     * @param   $date   date    date du jour sélectionné
     * @return  void
     */
    public function setCurrentDate( $date ) {
      $this->_current_date =& new CalendarDateModel( $this, $date );
    }

    /**
     * @brief   Retourne la date courante du calendrier
     * @return  CalendarDateModel
     */
    public function getCurrentDate() {
      return $this->_current_date;
    }

    /**
     * @brief   Retourne une collection des bornes du calendrier (01/01 - 12/31)
     * @return  array
     */
    public function getBounds() {
      return $this->_bounds;
    }

    /**
     * @brief   Retourne une collection des jours compris dans la période demandée
     * @param   $low_bound    CalendarDateModel   borne inférieure
     * @param   $high_bound   CalendarDateModel   borne supérieure
     * @return  array
     */
    public function getDays( CalendarDateModel &$low_bound, CalendarDateModel &$high_bound ) {
      $rv = array();

      $day_length = 86400;    //  60 * 60 * 24;

      $tmp = (string)$low_bound;
      $high_tstamp = (string)$high_bound;
      while( $tmp < $high_tstamp ) {
        $rv[] =& new CalendarDateModel( $this, $tmp );
        $tmp += $day_length;
      }

      $rv[] = $high_bound;

      return $rv;
    }

    /**
     * @brief   Initialise le calendrier d'après sa configuration
     * @return  void
     * @throw   Exception
     */
    public function init() {
      if ( is_null( $this->_current_date ) )
        throw new Exception( 'Current date required' );
      $year = date( 'Y', (string)$this->_current_date );

      $this->_bounds = array(
        'low' => new CalendarDateModel( $this, mktime( 0, 0, 0, 1, 1, $year ) ),
        'high' => new CalendarDateModel( $this, mktime( 0, 0, 0, 12, 31, $year ) )
      );
    }
  }
?>